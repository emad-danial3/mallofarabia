<?php

namespace App\Http\Controllers\Admin;


use App\Constants\OrderTypes;
use App\Exports\OrdersExport;
use App\Exports\OrderUserExport;
use App\Http\Controllers\Application\FawryPaymentController;
use App\Http\Repositories\OrderLinesRepository;
use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\ExportOrderHeadersSheet;
use App\Http\Requests\ExportShippingSheetSheetRequest;
use App\Http\Repositories\ProductRepository;
use App\Http\Requests\importUsersRequest;
use App\Http\Repositories\IUserRepository;
use App\Http\Services\CartService;
use App\Http\Services\PaymentService;
use App\Http\Services\OrderService;
use App\Http\Services\PaidOrderActions\SingleOrderPaidActions;
use App\Http\Services\UserService;
use App\Imports\OrdersImport;
use App\Models\Area;
use App\Models\Category;
use App\Models\City;
use App\Models\OrderHeader;
use App\Models\OrderLine;
use App\Models\OrderPrintHistory;
use App\Models\Product;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use App\Http\Services\OrderLinesService;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

use Auth;


class OrderHeaderController extends HomeController
{
    private   $OrderHeaderService;
    private   $OrderRequest;
    protected $CartService;
    protected $UserService;
    protected $PaymentService;
    private   $UserRepository;
    private   $OrderLinesService;

    private $SingleOrderPaidActions;
    private $ProductRepository;
    private $OrderLinesRepository;

    public function __construct(OrderLinesRepository $OrderLinesRepository, ProductRepository $ProductRepository, OrderService $OrderHeaderService, IUserRepository $UserRepository, SingleOrderPaidActions $SingleOrderPaidActions, OrderLinesService $OrderLinesService, Request $OrderRequest, CartService $CartService, PaymentService $PaymentService, UserService $UserService)
    {
        $this->OrderHeaderService     = $OrderHeaderService;
        $this->OrderRequest           = $OrderRequest;
        $this->CartService            = $CartService;
        $this->PaymentService         = $PaymentService;
        $this->UserRepository         = $UserRepository;
        $this->UserService            = $UserService;
        $this->OrderLinesService      = $OrderLinesService;
        $this->SingleOrderPaidActions = $SingleOrderPaidActions;
        $this->ProductRepository      = $ProductRepository;
        $this->OrderLinesRepository   = $OrderLinesRepository;
    }

    public function index()
    {
        $data = $this->OrderHeaderService->getAll(request()->all());
        return view('AdminPanel.PagesContent.OrderHeaders.index')->with('orderHeaders', $data);
    }

    public function getOracleNumberByOrderId(Request $request)
    {
        $name           = $request->name;
        $date_to        = $request->date_to;
        $date_from      = $request->date_from;
        $oracle_numbers = '';
        $orders         = [];
        if (((isset($date_to) && $date_to != '') && (isset($date_from) && $date_from != '')) || (isset($name) && $name != '')) {
            $orders = OrderHeader::with('order_lines');
            if ((isset($date_to) && $date_to != '') && (isset($date_from) && $date_from != '')) {
                $orders = $orders->whereBetween('created_at', [$date_from, $date_to]);
            }
            if (isset($name) && $name != '') {
                $orders = $orders->where('id', $name);
            }
            $orders = $orders->orderBy('order_headers.id', 'DESC')->get();
        }
        foreach ($orders as $lines) {
            $lines->order_lines = $this->unique_multidimensional_array($lines->order_lines, 'oracle_num');
        }
        return view('AdminPanel.PagesContent.OrderHeaders.oracle', compact('name', 'orders', 'oracle_numbers', 'date_to', 'date_from'));
//        return view('oracle_num',compact('name','orders','oracle_numbers','date_to','date_from'));
    }

    function unique_multidimensional_array($array, $key)
    {
        $temp_array = array();
        $i          = 0;
        $key_array  = array();
        foreach ($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i]  = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }

    public function create()
    {

        $products = Product::select('products.id', 'products.flag', 'products.excluder_flag', 'products.full_name', 'products.name_en', 'products.name_ar', 'products.description_en',
            'products.description_ar', 'products.image', 'products.oracle_short_code', 'products.discount_rate',
            'products.price', 'products.price_after_discount', 'products.quantity')
            ->where('products.stock_status', 'in stock')
            ->where('products.visible_status', '1');
        $products = $products->skip(0)
            ->take(10)->get();

        $user  = $this->UserService->getUser(Auth::User()->id);
        $users = $this->UserService->getAllUsers([]);

        $min_required = $this->calculateMinRequired($user);

        $categories = Category::
        where([['id', '!=', 13]])
            ->select(['id', 'name_en', 'name_ar'])
            ->withCount('productStock')
            ->having('product_stock_count', '>', 0)
            ->where('is_available', 1)
            ->get()
            ->makeHidden('product_stock_count');
        $cities     = City::select(['name_en', 'id'])->distinct()->get();

        return view('AdminPanel.PagesContent.OrderHeaders.form', compact('categories', 'products', 'cities', 'min_required', 'users'));

    }

    public function storeorder(Request $request)
    {

        $products = Product::select('products.id', 'products.flag', 'products.excluder_flag', 'products.full_name', 'products.name_en', 'products.name_ar', 'products.description_en',
            'products.description_ar', 'products.image', 'products.oracle_short_code', 'products.discount_rate',
            'products.price', 'products.price_after_discount', 'products.quantity')
            ->where('products.stock_status', 'in stock')
            ->where('products.visible_status', '1');
        $products = $products->skip(0)
            ->take(10)->get();

        $user  = $this->UserService->getUser(Auth::User()->id);
        $users = $this->UserService->getAllUsers([]);

        $min_required = $this->calculateMinRequired($user);

        $categories = Category::
        where([['id', '!=', 13]])
            ->select(['id', 'name_en', 'name_ar'])
            ->withCount('productStock')
            ->having('product_stock_count', '>', 0)
            ->where('is_available', 1)
            ->get()
            ->makeHidden('product_stock_count');
        $cities     = City::select(['name_en', 'id'])->distinct()->get();

        return view('AdminPanel.PagesContent.OrderHeaders.storeorder', compact('categories', 'products', 'cities', 'min_required', 'users'));

    }

    private function calculateMinRequired($user)
    {
        //refactoring
        if (isset($user->stage) && isset($user->freeaccount)) {
            if ($user->stage <= 2 && $user->freeaccount != 1)// activation premium account
                return $user->userType->min_required;
            elseif ($user->stage <= 2 && $user->freeaccount == 1)// activation free account
                return 125;
//        elseif ($user->stage == 3 && $user->freeaccount == 1) //single free order
//            return 150;
            else
                return 150; //any single order
        }
        else
            return 150;

    }

    public function getAllproducts(Request $request)
    {

        $inputData = $request;
        $products  = Product::select('products.id', 'products.flag', 'products.excluder_flag', 'products.full_name', 'products.name_en', 'products.name_ar', 'products.description_en',
            'products.description_ar', 'products.image', 'products.oracle_short_code', 'products.discount_rate',
            'products.price', 'products.price_after_discount', 'products.quantity')
            ->where('products.stock_status', 'in stock')
            ->where('products.visible_status', '1');

        if (isset($inputData['name']) && $inputData['name'] != '') {
            $products->where('products.name_en', 'like', '%' . $inputData['name'] . '%');
        }
        if (isset($inputData['code']) && $inputData['code'] != '') {
            $products->where('products.oracle_short_code', 'like', '%' . $inputData['code'] . '%');
        }
        if (isset($inputData['barcode']) && $inputData['barcode'] != '') {
            $products->where('products.barcode', $inputData['barcode']);
        }
        if (isset($inputData['category_id']) && $inputData['category_id'] != '') {
            $products->join('product_categories', 'product_categories.product_id', 'products.id')
                ->where('product_categories.category_id', $inputData['category_id']);
        }
        $products = $products->skip(0)
            ->take(15)->get();

//dd($products);

        $response = [
            'status'  => 200,
            'message' => "All Products",
            'data'    => $products
        ];
        return response()->json($response);

    }

    public function getAreasByCityID(Request $request)
    {

        $areas    = Area::select('id', 'region_en')->where("city_id", $request->city_id)->get();
        $response = [
            'status'  => 200,
            'message' => "All Products",
            'data'    => $areas
        ];
        return response()->json($response);
    }

    public function getSearchUserByName(Request $request)
    {
        $data = $this->UserService->getAllUsers(request()->all());
        if ($data) {
            $response = [
                'status'  => 200,
                'message' => "All Users",
                'data'    => $data
            ];
            return response()->json($response);
        }
    }

    public function getUserByName(Request $request)
    {
        $user = User::where('full_name', request()->all()['name'])->orWhere('phone', request()->all()['name'])->first();
        if ($user) {
            $response = [
                'status'  => 200,
                'message' => "All Users",
                'data'    => $user->id,
                'name'    => $user->full_name,
                'phone'    => $user->phone
            ];
            return response()->json($response);
        }

    }

    public function importOrderSheet(importUsersRequest $request)
    {
        $validated = $request->validated();
        try {
            Excel::import(new OrdersImport(), request()->file('file'));
            return redirect()->back()->with('message', 'Orders Updated Successfully');
        }
        catch (\Exception $exception) {
            return redirect()->back()->withErrors(['error' => 'Orders Error in Export']);
        }
    }

    public function getAllOrdersWithType(Request $request)
    {
        $data = $this->OrderHeaderService->getAll(['type' => $request['type']]);
        if (!empty($data) && count($data) > 0) {
            $response = [
                'status'  => 200,
                'message' => "All orders",
                'data'    => $data
            ];
            return response()->json($response);
        }
        else {
            $response = [
                'status'  => 400,
                'message' => "All orders",
                'data'    => null
            ];
            return response()->json($response);
        }
    }


    public function getAdminPrinteOrder(Request $request)
    {
        $data = OrderPrintHistory::where('order_header_id', $request->order_id)->with("admin")->get();
        if (!empty($data) && count($data) > 0) {
            $response = [
                'status'  => 200,
                'message' => "All admins",
                'data'    => $data
            ];
            return response()->json($response);
        }
        else {
            $response = [
                'status'  => 400,
                'message' => "All admins",
                'data'    => null
            ];
            return response()->json($response);
        }
    }

    public function CalculateProductsAndShipping(Request $request)
    {
        $user_id      = request()->input('user_id');
        $new_discount = request()->input('new_discount');
        $admin_id     = request()->input('admin_id');
        $store_id     = request()->input('store_id');
        $new_user_phone     = request()->input('new_user_phone');
        $new_user_name     = request()->input('new_user_name');

        if($user_id>1){
            $user_id=request()->input('user_id');;
        }elseif (isset($new_user_phone)&&isset($new_user_name)&&$new_user_phone!=''&& $new_user_name!=''){
            $dataNewUser=['full_name'=>$new_user_name,'phone'=>$new_user_phone];
            $user = User::create($dataNewUser);
            if($user){
                $user_id=$user->id;
            }
        }else{
            $user_id=1;
        }

        $newdata      = [
            "address_id" => 1,
            "items"      => request()->input('items')
        ];
        $new_discount = $new_discount > 0 ? $new_discount : 0;

        $productsAndTotal = $this->CartService->calculateProductsMall($newdata['items'], $new_discount);

        if (!empty($productsAndTotal) && !empty($productsAndTotal['products'])) {
            $productsAndTotal['shipping'] = 0;
            $this->CartService->saveProductsToCart($productsAndTotal['products'], $user_id, $user_id);
            $this->CartService->saveCartHeader($user_id, $user_id, $productsAndTotal['totalProducts'], $productsAndTotal['totalProductsAfterDiscount'], $productsAndTotal['shipping'], $productsAndTotal['discount_amount']);
            $data  = [
                "user_id"         => $user_id,
                "admin_id"        => $admin_id,
                "store_id"        => $store_id,
                "address_id "     => intval($newdata['address_id']),
                "shipping_amount" => 0,
                'payment_code'    => NULL,
                'wallet_status'   => 'cash',
                'total_order'     => $productsAndTotal['totalProductsAfterDiscount'],
                'sub_total'     =>round($productsAndTotal['totalProductsAfterDiscount']-$productsAndTotal['tax']),
                'discount_amount' => $productsAndTotal['discount_amount'],
                'tax' => $productsAndTotal['tax'],
            ];
            $order = OrderHeader::create($data);
            OrderHeader::where('id', $order->id)->update(['address_id' => intval($newdata['address_id'])]);
            if (!empty($order)) {
                $productsAndTotal['order_id'] = $order->id;
                $this->OrderLinesService->createOrderLines($order['id'], $data['user_id'], $data['user_id']);
                $this->OrderLinesService->deleteCartAndCartHeader($data['user_id'], $data['user_id']);
            }
            $response = [
                'status'  => 200,
                'message' => "Order Add Success",
                'data'    => $productsAndTotal
            ];
            return response()->json($response);
        }
        $response = [
            'status'  => 401,
            'message' => "No Products",
            'data'    => null
        ];
        return response()->json($response);
    }

    public function makeOrderPayInAdmin(Request $request)
    {
        $order_id      = request()->input('order_id');
        $wallet_status = request()->input('wallet_status');
        $wallet_status = isset($wallet_status) && $wallet_status == 'visa' ? 'visa' : "cash";
        $updateOrder   = OrderHeader::where('id', $order_id)->update(['payment_status' => 'PAID', 'wallet_status' => $wallet_status]);
        $response = [
            'status'  => 200,
            'message' => "order updated successfully",
            'data'    => $updateOrder
        ];
        return response()->json($response);
    }

    public function store()
    {
    }

    public function show(OrderHeader $orderHeader)
    {
        $orderHeader = OrderHeader::where('id', $orderHeader->id)->first();
        if (!empty($orderHeader) && $orderHeader->is_printed == '1') {
            return "this Invoice Printed before If You want please return to 4UNettingHub management ";
        }
        else {
            $orderHeader->is_printed = '1';
            $orderHeader->save();
            OrderPrintHistory::create(['order_header_id' => $orderHeader->id, 'admin_id' => \Illuminate\Support\Facades\Auth::guard('admin')->user()->id]);
            $orderNumber    = $orderHeader->id;
            $invoicesCount  = OrderLine::select('oracle_num')->where('order_id', $orderNumber)->distinct()->count('oracle_num');
            $invoicesNumber = OrderLine::leftJoin('oracle_invoices', function ($join) {
                $join->on('oracle_invoices.web_order_number', '=', 'order_lines.oracle_num');
            })->select('order_lines.oracle_num', 'oracle_invoices.oracle_invoice_number')->where('order_lines.order_id', $orderNumber)->distinct('order_lines.oracle_num')->get();

            $invoicesLines      = DB::select('SELECT ol.oracle_num ,p.price pprice,p.tax ptax,ol.price olprice,p.name_en psku,ol.quantity olquantity FROM order_lines ol,products p
     	                        where 	ol.order_id =' . $orderNumber . '
     	                        and ol.product_id = p.id ');
            $invoicesTotalPrice = OrderLine::where('order_id', $orderNumber)->sum('quantity');
            $user               = User::where('id', $orderHeader->user_id)->first();
            return view('AdminPanel.PagesContent.OrderHeaders.show', compact('orderHeader', 'invoicesNumber', 'invoicesCount', 'invoicesLines', 'invoicesTotalPrice', 'user'));
        }
    }

    public function view($id)
    {

        $orderHeader    = OrderHeader::where('id', $id)->first();
        $orderNumber    = $orderHeader->id;
        $invoicesCount  = OrderLine::select('oracle_num')->where('order_id', $orderNumber)->distinct()->count('oracle_num');
        $invoicesNumber = OrderLine::leftJoin('oracle_invoices', function ($join) {
            $join->on('oracle_invoices.web_order_number', '=', 'order_lines.oracle_num');
        })->select('order_lines.oracle_num', 'oracle_invoices.oracle_invoice_number')->where('order_lines.order_id', $orderNumber)->distinct('order_lines.oracle_num')->get();

        $invoicesLines      = DB::select('SELECT ol.oracle_num ,p.price pprice,p.tax ptax,ol.price olprice,p.name_en psku,ol.quantity olquantity FROM order_lines ol,products p
     	                        where 	ol.order_id =' . $orderNumber . '
     	                        and ol.product_id = p.id ');
        $invoicesTotalPrice = OrderLine::where('order_id', $orderNumber)->sum('quantity');
        $user               = User::where('id', $orderHeader->user_id)->first();
        return view('AdminPanel.PagesContent.OrderHeaders.view', compact('orderHeader', 'invoicesNumber', 'invoicesCount', 'invoicesLines', 'invoicesTotalPrice', 'user'));

    }

    public function print80c($id)
    {
        $taxVal=0;
        $orderHeader        = OrderHeader::where('id', $id)->first();
        $orderNumber        = $orderHeader->id;
        $invoicesCount      = OrderLine::select('oracle_num')->where('order_id', $orderNumber)->distinct()->count('oracle_num');
        $invoicesNumber     = OrderLine::select('oracle_num')->where('order_id', $orderNumber)->distinct()->get();
        $invoicesLines      = DB::select('SELECT ol.oracle_num ,ol.price pprice,p.tax ptax,p.price newprice,ol.price * ol.quantity  olprice,p.name_en psku,ol.quantity olquantity FROM order_lines ol,products p
     	                        where 	ol.order_id =' . $orderNumber . '
     	                        and ol.product_id = p.id ');
        $invoicesTotalPrice = OrderLine::where('order_id', $orderNumber)->sum('quantity');
        $user               = User::where('id', $orderHeader->user_id)->first();
        foreach ($invoicesLines as $invoicesLine){
            $taxVal +=  (($invoicesLine->ptax * $invoicesLine->newprice)/100);
        }
        // send to oracle
//        $this->PaymentService->sendOrderToOracleMallOfArabia($orderNumber);
        return view('AdminPanel.PagesContent.OrderHeaders.print80c', compact('orderHeader', 'invoicesNumber', 'invoicesCount', 'invoicesLines', 'invoicesTotalPrice', 'user','taxVal'));
    }

    public function edit(OrderHeader $orderHeader)
    {
        $orderNumber    = $orderHeader->id;
        $invoicesCount  = OrderLine::select('oracle_num')->where('order_id', $orderNumber)->distinct()->count('oracle_num');
        $invoicesNumber = OrderLine::select('oracle_num')->where('order_id', $orderNumber)->distinct()->get();
        $invoicesLines  = DB::select('SELECT ol.product_id, ol.oracle_num ,p.price pprice,p.tax ptax,ol.price olprice,p.name_en psku,ol.quantity olquantity FROM order_lines ol,products p
     	                        where 	ol.order_id =' . $orderNumber . '
     	                        and ol.product_id = p.id ');

        $invoicesTotalPrice = OrderLine::where('order_id', $orderNumber)->sum('quantity');
        $user               = User::where('id', $orderHeader->user_id)->first();

        return view('AdminPanel.PagesContent.OrderHeaders.refund', compact('orderHeader', 'invoicesNumber', 'invoicesCount', 'invoicesLines', 'invoicesTotalPrice', 'user'));

    }

    public function refundOrderWallet($user_id, $oldTotalOrder, $newTotalOrder)
    {
        $walletEvaluation = $this->WalletEvaluationRepository->find(1, ['value', 'amount']);
        $myCurrentWallet  = $this->UserWalletRepository->getCurrentWallet($user_id);
        if (!empty($myCurrentWallet)) {
            $oldWithdrawalBeforOrderCount = floor(((float)$myCurrentWallet->total_orders_amount - (float)$oldTotalOrder) / $walletEvaluation->value);
            if ($myCurrentWallet->withdrawal_order_count != $oldWithdrawalBeforOrderCount) {
                $difCount = $myCurrentWallet->withdrawal_order_count - $oldWithdrawalBeforOrderCount;
                $this->UserWalletRepository->updateWallet(['user_id' => $user_id], [
                    'total_orders_amount'    => ((float)$myCurrentWallet->total_orders_amount - (float)$oldTotalOrder),
                    'withdrawal_order_count' => $oldWithdrawalBeforOrderCount,
                    'total_wallet'           => ($myCurrentWallet->total_wallet - ($walletEvaluation->amount * $difCount)),
                    'current_wallet'         => $myCurrentWallet->current_wallet - ($walletEvaluation->amount * $difCount),
                ]);
                $this->SingleOrderPaidActions->addOrderToMyWallet($user_id, $walletEvaluation, (float)$newTotalOrder);
            }
            else {
                $this->UserWalletRepository->updateWallet(['user_id' => $user_id], [
                    'total_orders_amount' => ((float)$myCurrentWallet->total_orders_amount - ((float)$oldTotalOrder - (float)$newTotalOrder)),
                ]);
            }
        }
    }

    public function refundOrderWalletToMyParent($child_id, $oldTotalOrder, $newTotalOrder, $orderId)
    {
        $my_parents = $this->UserRepository->getAccountParent($child_id);
        foreach ($my_parents as $parent) {
            // if this parent Exist in wallet history
            if ($this->UserWalletRepository->parentHaveWalletForThisOrder($parent->parent_id, $orderId)) {
                $this->refundOrderWallet($parent->parent_id, $oldTotalOrder, $newTotalOrder);
            }
        }
    }

    public function refundOrderPaymentOnline($oldTotalOrder, $newTotalOrder, $payment_code)
    {
        $diffamount       = ((float)$oldTotalOrder - (float)$newTotalOrder);
        $newdif           = number_format((float)$diffamount, 2, '.', '');
        $merchantCode     = '1tSa6uxz2nQFNIFa9AHjDA==';
        $referenceNumber  = $payment_code;
        $refundAmount     = strval($newdif);
        $reason           = 'Item not as described';
        $merchant_sec_key = 'b560c6003c9a4f95b963a7f3c965e24c'; // For the sake of demonstration
        $signature        = hash('sha256', $merchantCode . $referenceNumber . $refundAmount . $reason . $merchant_sec_key);
        $httpClient       = new \GuzzleHttp\Client(); // guzzle 6.3

        $response = $httpClient->request('POST', 'https://atfawry.fawrystaging.com/ECommerceWeb/Fawry/payments/refund', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json'
            ],
            'body'    => json_encode([
                'merchantCode'    => $merchantCode,
                'referenceNumber' => $referenceNumber,
                'refundAmount'    => $refundAmount,
                'reason'          => $reason,
                'signature'       => $signature
            ], true)
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    public function update(Request $request, OrderHeader $orderHeader)
    {
        $this->refundOrderWallet($orderHeader->user_id, $orderHeader->total_order, $request->total_order);
        $this->refundOrderWalletToMyParent($orderHeader->user_id, $orderHeader->total_order, $request->total_order, $orderHeader->id);

        $orderCommission             = UserCommission::where('user_id', $orderHeader->user_id)->where('order_id', $orderHeader->id)->first();
        $orderCommission->commission = ((float)$orderCommission->commission_percentage / 100 * (float)$request->total_order);
        $orderCommission->save();

        if (isset($request->product_ids) && count($request->product_ids) > 0) {
            OrderLine::where('order_id', $orderHeader->id)->whereIn('product_id', $request->product_ids)->delete();
            OrderHeader::where('id', $orderHeader->id)->update(['total_order' => (float)$request->total_order, 'updated_at' => now()]);
        }

        if ($orderHeader->wallet_status == 'full_wallet') {
            $mywallet                 = $this->UserWalletRepository->getCurrentWallet($orderHeader->user_id);
            $mywallet->current_wallet = ((float)$mywallet->current_wallet + ((float)$orderHeader->total_order - (float)$request->total_order));
            $mywallet->save();
            $response['statusDescription'] = 'Operation done successfully';
        }
        elseif ($orderHeader->wallet_status == 'only_fawry') {
            $response = $this->refundOrderPaymentOnline($orderHeader->total_order, $request->total_order, $orderHeader->payment_code);
        }
        $statusDescription = $response['statusDescription']; // get response statusDescription
        return redirect('https://4unettinghub.com/admin/orderHeaders/' . $orderHeader->id . '/edit?message=' . $statusDescription);
    }

    public function destroy(OrderHeader $product)
    {
    }

    public function ExportOrderHeadersSheet(ExportOrderHeadersSheet $request)
    {
        $validated = $request->validated();
        try {
            if ($request->input('with') == 'user')
                return Excel::download(new OrderUserExport($validated['start_date'], $validated['end_date'], $validated['payment_status']), 'orders.xlsx');

            else
                return Excel::download(new OrdersExport($validated['start_date'], $validated['end_date'], $validated['payment_status']), 'orders.xlsx');
        }
        catch (\Exception $exception) {

            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }
    }

    public function ExportOrderCharge(Request $request)
    {

        $oldbill      = RtoSOrders::where('order_header_id', $request->order_id)->first();
        $orderAddress = UserAddress::join('order_headers', 'order_headers.address_id', '=', 'user_addresses.id')->where('order_headers.id', $request->order_id)->select('user_addresses.*')->first();
        if (!$oldbill) {
//            CAIRO
            $data = [
                "waybillRequestData" => [
                    "FromOU"                    => "",
                    "WaybillNumber"             => "",
                    "DeliveryDate"              => "",
                    "CustomerCode"              => env('R2S_clientCode'),
                    "ConsigneeCode"             => "00000",
                    "ConsigneeAddress"          => !empty($orderAddress) && isset($orderAddress->address) ? $orderAddress->address : "Test Order Address",
                    "ConsigneeCountry"          => "EG",
                    "ConsigneeState"            => $request->user_city,
                    "ConsigneeCity"             => $request->user_area,
                    "ConsigneePincode"          => "8523",
                    "ConsigneeName"             => $request->user_name,
                    "ConsigneePhone"            => $request->user_phone,
                    "ClientCode"                => env('R2S_clientCode'),
                    "NumberOfPackages"          => 1,
                    "ActualWeight"              => 1,
                    "ChargedWeight"             => "",
                    "CargoValue"                => 1100,
                    "ReferenceNumber"           => $request->order_id,
                    "InvoiceNumber"             => $request->order_id,
                    "CreateWaybillWithoutStock" => "False",
                    "PaymentMode"               => "TBB",
                    "ServiceCode"               => "PUD",
                    "WeightUnitType"            => "KILOGRAM",
                    "Description"               => "VZXC",
                    "COD"                       => 1125,
                    "CODPaymentMode"            => "CASH",
                    "packageDetails"            => [
                        "packageJsonString" => [
                            [
                                "barCode"                 => "",
                                "packageCount"            => 1,
                                "length"                  => 20,
                                "width"                   => 20,
                                "height"                  => 20,
                                "weight"                  => 1,
                                "itemCount"               => 1,
                                "chargedWeight"           => 1,
                                "selectedPackageTypeCode" => "BOX"
                            ]
                        ]
                    ]
                ]
            ];

            try {
                $httpClient = new \GuzzleHttp\Client(); // guzzle 6.3
                $response   = $httpClient->request('POST', 'https://api.r2slogistics.com/CreateWaybill?secureKey=' . env('R2S_secureKey'), [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept'       => 'application/json'
                    ],
                    'body'    => json_encode($data, true)
                ]);

                $rrespose = json_decode($response->getBody()->getContents(), true);
//              dd($rrespose);
                if ($rrespose['messageType'] == 'Success') {
                    $rrespose['order_header_id'] = $request->order_id;
                    RtoSOrders::create($rrespose);
                    $updateOrder = OrderHeader::where('id', $request->order_id)->first();
                    if ($updateOrder) {
                        $updateOrder->waybillNumber = $rrespose['waybillNumber'];
                        $updateOrder->save();
                    }
                    $filename  = 'chargePDF' . $request->order_id . '.pdf';
                    $tempImage = tempnam(sys_get_temp_dir(), $filename);
                    copy($rrespose['labelURL'], $tempImage);
                    return response()->download($tempImage, $filename);
                }
                else {
                    return redirect()->back()->withErrors(['error' => $rrespose['message']]);
                }

            }
            catch (\Exception $exception) {
                return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
            }
        }
        else {
            $filename  = 'chargePDF' . $request->order_id . '.pdf';
            $tempImage = tempnam(sys_get_temp_dir(), $filename);
            copy($oldbill['labelURL'], $tempImage);
            return response()->download($tempImage, $filename);
        }
    }

    public function changeOrderChargeStatus(Request $request)
    {
        $oldbill     = RtoSOrders::where('order_header_id', $request->order_id)->first();
        $orderHeader = OrderHeader::where('id', $request->order_id)->first();
        if ($oldbill && $oldbill->waybillNumber) {
            $url = 'https://webservice.logixerp.com/webservice/v2/MultipleWaybillTracking?SecureKey=' . env('R2S_secureKey') . '&WaybillNumber=' . $oldbill->waybillNumber;

            try {
                $httpClient = new \GuzzleHttp\Client(); // guzzle 6.3
                $response   = $httpClient->request('GET', $url);
                $rrespose   = json_decode($response->getBody()->getContents(), true);

                if ($rrespose && isset($rrespose['waybillTrackDetailList']) && isset($rrespose['waybillTrackDetailList'][0])) {
                    $oldbill->status = $rrespose['waybillTrackDetailList'][0]['currentStatus'];
                    $oldbill->save();
                    $orderHeader->order_status = $rrespose['waybillTrackDetailList'][0]['currentStatus'];
                    $orderHeader->save();
                    return redirect()->back()->with('message', 'Updated successfully');
                }
                else {
                    return redirect()->back()->withErrors(['error' => 'error in R2S response']);
                }
            }
            catch (\Exception $exception) {
                return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
            }
        }
        return redirect()->back()->withErrors(['error' => 'no way bill Number']);
    }

    public function cancelOrderCharge(Request $request)
    {
        if ($request->order_id && $request->waybillNumber) {
            $url = 'https://api.r2slogistics.com/UpdateWaybill?secureKey=' . env('R2S_secureKey') . '&WaybillNumber=' . $request->waybillNumber;
            try {
                $data       = [
                    "waybillStatus"    => "Cancelled",
                    "cancelledRemarks" => "Test",
                    "waybillNumber"    => $request->waybillNumber,
                ];
                $httpClient = new \GuzzleHttp\Client(); // guzzle 6.3
                $response   = $httpClient->request('POST', $url, ['form_params' => $data, 'verify' => false])->getBody()->getContents();
                $rrespose   = json_decode($response, true);
                if ($rrespose['success'] == true) {
                    $res = json_decode($rrespose['response'], true);
                    if (isset($res['messageType']) && $res['messageType'] == 'Success') {
                        return redirect()->back()->with('message', $res['message']);
                    }
                    else {
                        return redirect()->back()->withErrors(['error' => 'error occurred']);
                    }
                }
                else {
                    return redirect()->back()->withErrors(['error' => 'error in R2S response']);
                }
            }
            catch (\Exception $exception) {
                return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
            }
        }
        return redirect()->back()->withErrors(['error' => 'no way bill Number']);
    }

    public function cancelOrderQuantity(Request $request)
    {
        if ($request->order_id) {
            $orderHeader = OrderHeader::where('id', $request->order_id)->first();
            try {
                $OrderLines = $this->OrderLinesRepository->getOrderLines($request->order_id);
                if (isset($OrderLines) && count($OrderLines) > 0) {
                    for ($i = 0; $i < count($OrderLines); $i++) {
                        $product = $this->ProductRepository->find($OrderLines[$i]->product_id, ['id', 'quantity', 'stock_status']);
                        if (!empty($product)) {
                            $quantity = intval($product->quantity) + intval($OrderLines[$i]->quantity);
                            $data     = ['quantity' => $quantity];

                            if ($product->stock_status == 'out stock') {
                                $data = ['quantity' => $quantity, 'stock_status' => 'in stock'];
                            }
                            $this->ProductRepository->updateData(['id' => $product->id], $data);
                        }
                    }
                }

                $orderHeader->order_status    = 'Cancelled';
                $orderHeader->payment_status  = 'CANCELED';
                $orderHeader->canceled_reason = $request->canceled_reason;
                $orderHeader->save();
                return redirect()->back()->with('message', 'Products updated success');
            }
            catch (\Exception $exception) {
                return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
            }
        }
        return redirect()->back()->withErrors(['error' => 'no order To cancel']);
    }

    public function CreatePickupRequest(Request $request)
    {
        $orderHeader  = OrderHeader::where('id', $request->order_id)->first();
        $orderAddress = UserAddress::join('order_headers', 'order_headers.address_id', '=', 'user_addresses.id')->where('order_headers.id', $request->order_id)->select('user_addresses.*')->first();
        if ($orderHeader && $orderHeader->waybillNumber) {
            try {
                $client   = new \GuzzleHttp\Client();
                $data     = [
                    'readyTime'           => '09:00:00',
                    'latestTimeAvailable' => '14:00:00',
                    'pickupAddress'       => !empty($orderAddress) && isset($orderAddress->address) ? $orderAddress->address : "Test Order Address",
                    'pickupCountry'       => "Egypt",
                    'pickupState'         => $request->user_city,
                    'pickupPincode'       => "",
                    'pickupDate'          => $request->pickupDate, //2020-10-25
                    'clientCode'          => env('R2S_clientCode'),
                    'consignorCode'       => "",
                    'pickupCity'          => $request->user_area,
                    'wayBillNumbers'      => $orderHeader->waybillNumber,
                ];
                $response = $client->request('POST', 'https://api.r2slogistics.com/CreatePickupRequest?secureKey=' . env('R2S_secureKey'), ['form_params' => $data, 'verify' => false])->getBody()->getContents();

                $rrespose = json_decode($response, true);
                if ($rrespose['messageType'] == 'Success') {
                    return redirect()->back()->with('message', $rrespose['message']);
                }
                else {
                    return redirect()->back()->withErrors(['error' => $rrespose['message']]);
                }

            }
            catch (\Exception $exception) {
                return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
            }
        }
        return redirect()->back()->withErrors(['error' => 'no way bill Number']);
    }


    public function ExportShippingSheetSheet()
    {
        return view('AdminPanel.PagesContent.OrderHeaders.shippingSheet');
    }

    public function HandelExportShippingSheetSheet(ExportShippingSheetSheetRequest $request)
    {
        $validated = $request->validated();
        try {
            return Excel::download(new ShippingSheetSheetExport($validated['start_date'], $validated['end_date']), 'orders.xlsx');
        }
        catch (\Exception $exception) {

            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }
    }

    public function ChangeStatusForOrder()
    {
        $orderHeaders = $this->OrderHeaderService->getPendingOrders();
        return view('AdminPanel.PagesContent.OrderHeaders.changeOrderStatus', compact('orderHeaders'));
    }


    public function HandelChangeStatusForOrder(ChangeStatusRequest $request)
    {
        $inputs            = $request->validated();
        $order_id          = $inputs['order_id'];
        $data['item_code'] = "orderNumber-" . $order_id;
        $this->OrderRequest->request->add([
            'fawryRefNumber' => '123454',
            'orderStatus'    => 'PAID',
            'paymentMethod'  => 'BackEndPAY',
            'orderItems'     => [
                $data
            ]
        ]);
        $order = app(FawryPaymentController::class)->changeOrderStatus($this->OrderRequest);
        return redirect()->back()->with(['message' => json_encode($order->original)]);
    }
}
