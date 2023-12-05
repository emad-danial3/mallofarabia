<?php

namespace App\Http\Controllers\Website\User;

use App\Constants\OrderStatus;
use App\Constants\PaymentNames;
use App\Http\Controllers\Controller;
use App\Http\Services\OrderLinesService;
use App\Http\Services\OrderService;
use App\Http\Services\PaymentService;
use App\Models\City;
use App\Models\Country;
use App\Models\OrderHeader;
use App\Models\Review;
use App\Models\WelcomeProgramProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Services\UserService;
use App\Http\Services\CartService;
use App\Http\Services\ProductService;
use App\Models\User;
use App\Models\UserAddress;
use Auth;
use Session;
use Illuminate\Support\Facades\DB;

class UserCartController extends Controller
{
    protected $OrderHeaderService;
    protected $UserService;
    protected $CartService;
    protected $OrderLinesService;
    protected $OrderService;
    protected $PaymentService;
    private   $ProductService;

    public function __construct(ProductService $ProductService, PaymentService $PaymentService, OrderService $OrderService, UserService $UserService, CartService $CartService, OrderLinesService $OrderLinesService)
    {
        $this->UserService       = $UserService;
        $this->CartService       = $CartService;
        $this->OrderLinesService = $OrderLinesService;
        $this->OrderService      = $OrderService;
        $this->PaymentService    = $PaymentService;
        $this->ProductService    = $ProductService;
    }

    public function index()
    {
        return view('cart.cart');
    }

    public function getCheckout()
    {
        $addresses   = null;
        $currentuser = Auth::user();
        if (!empty($currentuser)) {
            $conditions = ['user_addresses.user_id', '=', $currentuser->id];
            $addresses  = $this->UserService->getUserAddress($conditions);
        }

        $countries = Country::all();
        $cities    = null;
        if (!empty($countries)) {
            $cities = City::where('country_id', $countries[0]->id)->get();
        }
        return view('cart.checkout', compact('addresses', 'countries', 'cities'));
    }

    public function checkUserDeserveGift($user_id, $created_at)
    {
        return $this->UserService->checkUserDeserveGift($user_id, $created_at);
    }

    public function orderSuccess(Request $request, $id)
    {
        $currentuser = Auth::user();

        if (!empty($currentuser)) {
            $order = $this->OrderService->getMyOrderDetails($id);

            if (!empty($order) && !empty($order['order_header']) && $order['order_header']['wallet_status'] == 'only_fawry' && $order['order_header']['payment_status'] == 'PENDING') {
                $data = [
                    'order_id' => $id,
                    'type'     => 'web',
                ];
                return $this->payWithfawry($request, $data);
            }
            else {
                $address   = $this->UserService->getUserAddress(['user_addresses.id', '=', $order['order_header']['address_id']]);
                $address   = $address ? $address[0] : null;
                $gift      = WelcomeProgramProduct::find($order['order_header']['gift_id']);
                $giftPrice = 0;
                if (!empty($gift)) {
                    $giftPrice = (float)$gift->price_after_discount;
                }
                $totalProducts = ((float)$order['order_header']->total_order + (float)$order['order_header']->discount_amount - (float)$order['order_header']->shipping_amount - $giftPrice);
                $totalOrder    = ((float)$order['order_header']->total_order);
                $afterDiscount = ((float)$totalProducts - (float)$order['order_header']->discount_amount);
                return view('cart.orderSuccess', compact('id', 'address', 'order', 'totalProducts', 'totalOrder', 'giftPrice', 'afterDiscount'));
            }
        }
        return Redirect('/login');
    }

    public function orderDetails(Request $request, $id)
    {

        $currentuser = Auth::user();

        if (!empty($currentuser)) {
            $order = $this->OrderService->getMyOrderDetails($id);

                $address   = $this->UserService->getUserAddress(['user_addresses.id', '=', $order['order_header']['address_id']]);
                $address   = $address && count($address)> 0 ? $address[0] : null;
                $gift      = WelcomeProgramProduct::find($order['order_header']['gift_id']);
                $giftPrice = 0;
                if (!empty($gift)) {
                    $giftPrice = (float)$gift->price_after_discount;
                }
                $totalProducts = ((float)$order['order_header']->total_order + (float)$order['order_header']->discount_amount - (float)$order['order_header']->shipping_amount - $giftPrice);
                $totalOrder    = ((float)$order['order_header']->total_order);
                $afterDiscount = ((float)$totalProducts - (float)$order['order_header']->discount_amount);

                return view('cart.orderDetails', compact('id', 'address', 'order', 'totalProducts', 'totalOrder', 'giftPrice', 'afterDiscount'));

        }
        return Redirect('/login');
    }

    public function saveWebOrder(Request $request)
    {
        $inputs = $request->all();
        $currentuser = Auth::user();
        if (!empty($currentuser)) {
            if ($currentuser->created_at < '2023-04-19') {
                $now = Carbon::now()->toDateTimeString();
                $data = ['created_at' => $now];
                $this->UserService->updateUserRow($data, $currentuser->id);
            }

            $hasDiscount      = $currentuser->stage == 2 ? 1 : 0;
            $productsAndTotal = $this->CartService->calculateProducts($inputs['items'], $hasDiscount);
            if (!empty($productsAndTotal)) {
                $productsAndTotal['shipping'] = ((float)$productsAndTotal['totalProductsAfterDiscount']) < 250 ? 50 : 0;
                $this->CartService->saveProductsToCart(array_merge($productsAndTotal['products'],$productsAndTotal['giftProducts']), $currentuser->id, $currentuser->id);
                $this->CartService->saveCartHeader($currentuser->id, $currentuser->id, $productsAndTotal['totalProducts'], ($productsAndTotal['totalProductsAfterDiscount'] + $productsAndTotal['value_will_has_commission']), $productsAndTotal['shipping'], $productsAndTotal['discount_amount']);

                $data = [
                    "user_id"                    => $currentuser->id,
                    "address_id "                => intval($inputs['address_id']),
                    "shipping_amount"            => $productsAndTotal['shipping'],
                    "totalProducts"              => $productsAndTotal['totalProducts'],
                    'payment_code'               => NULL,
                    'wallet_status'              => $inputs['wallet_status'],
                    'total_order'                => (float)$productsAndTotal['totalProductsAfterDiscount'] + $productsAndTotal['shipping'],

                    'discount_amount'            => $productsAndTotal['discount_amount'],
                    'gift_id'                    => isset($productsAndTotal['userRedeemGift']) && $productsAndTotal['userRedeemGift'] == true ? $productsAndTotal['userIdGift'] : 0
                ];

                $order             = OrderHeader::create($data);
                $order->address_id = intval($inputs['address_id']);
                $order->save();
                if (!empty($order)) {
                    $productsAndTotal['order_id'] = $order->id;

                    $this->OrderLinesService->createOrderLines($order['id'], $data['user_id'], $data['user_id']);
                    $this->OrderLinesService->deleteCartAndCartHeader($data['user_id'], $data['user_id']);
//                    if ($inputs['wallet_status'] == 'cash') {
//                        $this->PaymentService->sendOrderToOracle($order->id);
//                        if (isset($order->id) && $order->id > 0) {
//                            $this->ProductService->updateOrderProductQuntity($order->id);
//                        }
//                    }
                }


                $response = [
                    'status'  => 200,
                    'message' => "Order Add Success",
                    'data'    => $productsAndTotal
                ];
                return response()->json($response);
            }
            $response = [
                'status'  => 200,
                'message' => "All Products",
                'data'    => null
            ];
            return response()->json($response);
        }
    }

    public function saveProductReview(Request $request)
    {
        $inputs = $request->all();

        $currentuser = Auth::user();
        if (!empty($currentuser)) {
            $data         = [
                "user_id"    => $currentuser->id,
                "rate "      => $inputs['rate'],
                "product_id" => $inputs['product_id'],
                "comment"    => $inputs['comment'],
            ];
            $Review       = Review::create($data);
            $Review->rate = $inputs['rate'];
            $Review->save();
            if (!empty($Review)) {
                $response = [
                    'status'  => 200,
                    'message' => "Order Add Success",
                    'data'    => $Review
                ];
                return response()->json($response);
            }
        }
        else {
            $response = [
                'status'  => 401,
                'message' => "user Not Authorized",
                'data'    => null
            ];
            return response()->json($response);
        }
    }

    public function checkWebOrder(Request $request)
    {
        $inputs      = $request->all();
        $currentuser = Auth::user();
        if (!empty($currentuser)) {
            $hasDiscount = $currentuser->stage == 2 ? 1 : 0;
            $checkItemsAvalability = $this->CartService->checkItemsAvalability($inputs['items']);

            if ($checkItemsAvalability && count($checkItemsAvalability) > 0) {
                $response = [
                    'status'  => 201,
                    'message' => "products Quantity More than Quantity In stock  Or more than 6 piece",
                    'data'    => $checkItemsAvalability,
                ];
                return response()->json($response);
            }
            $productsAndTotal = $this->CartService->calculateProducts($inputs['items'], $hasDiscount);

            if (!empty($productsAndTotal)) {
                $productsAndTotal['shipping']                  = ((float)$productsAndTotal['totalProductsAfterDiscount']) < 250 ? 50 : 0;
                $productsAndTotal['total_order_final']         = ((float)$productsAndTotal['totalProductsAfterDiscount']) + $productsAndTotal['shipping'];
                $productsAndTotal['value_will_has_commission'] = ((float)$productsAndTotal['value_will_has_commission']);
            }
            $gift = null;
            if ($hasDiscount == 1) {
                $userHasReceivedGift          = $this->UserService->userHasReceivedGift([$currentuser->id]);
                $myOldPaidOrderThisMonthTotal = $this->UserService->getMyTeamTotalSales([$currentuser->id], 'month');
                if (((float)$productsAndTotal['totalProductsAfterDiscount'] + $myOldPaidOrderThisMonthTotal) >= 250 && $userHasReceivedGift == false) {
                    $gift = $this->checkUserDeserveGift($currentuser->id, $currentuser->created_at);
                }
            }

            $response = [
                'status'  => 200,
                'message' => "check Web Order",
                'data'    => $productsAndTotal,
                'gift'    => $gift
            ];
            return response()->json($response);
        }
        $response = [
            'status'  => 401,
            'message' => "All Products",
            'data'    => null
        ];
        return response()->json($response);
    }

    public function payWithfawry(Request $request, $requestData = null)
    {
        if ($requestData == null) {
            $inputs = $request->all();
        }
        else {
            $inputs = $requestData;
        }

        $currentuser = Auth::user();
        $platform    = 'web';
        if ($inputs && isset($inputs['type']) && $inputs['type'] == 'admin') {
            $platform = 'admin';
            if (empty($currentuser)) {
                $user_id     = OrderHeader::where('id', $inputs['order_id'])->first()['user_id'];
                $currentuser = User::where('id', $user_id)->first();
            }
        }
        if (!empty($currentuser)) {
            $order_header = OrderHeader::select('id', 'total_order', 'shipping_amount', 'address_id')->where('id', $inputs['order_id'])->first();
            $order        = DB::select('SELECT
       p.name_en as psku,p.description_en as pdescription,ol.price as olprice,ol.quantity as olquantity,
       ol.product_id as olitemcode,p.image as pimage , ol.order_id as olorder_num
FROM order_lines ol , products p
                              WHERE ol.product_id=p.id and ol.order_id=' . $order_header->id . '

	                      ');

            $total_order = $order_header->total_order;
            $pprice      = $order_header->shipping_amount;
            $user        = $currentuser;
            $Adid        = $order_header->address_id > 0 ? $order_header->address_id : 1;

            $address = UserAddress::where('id', $Adid)->first();

            // orders items
            // sort items
            array_push($order, (object)['olitemcode' => $order_header->id, 'psku' => 'shipping Amount', 'olprice' => $pprice, 'olquantity' => 1, 'pimage' => '', 'olorder_num' => $order_header->id]);
            foreach ($order as $orderrhh) {
                $orderrhh->olitemcode = strval($orderrhh->olitemcode);
            }
            usort($order, function ($a, $b) {
                return strcmp($a->olitemcode, $b->olitemcode);
            });
            if (count($order) > 0) {
                $itm = '';
                foreach ($order as $orderr) {
                    $itm .= $orderr->olitemcode . $orderr->olquantity . number_format((float)$orderr->olprice, 2, '.', '');
                }
            }
            $rand              = rand(10, 100);
            $merchantCode      = 'TWp4BK7owYobL082js6IXg==';
            $merchantRefNum    = $rand . '-' . $order_header->id;
            $amount            = $order_header->total_order;
            $customerProfileId = $user->account_id;
            $merchant_sec_key  = 'a4a4860d4df64eec90f4937dcbfa44c1'; // For the sake of demonstration
            $returnUrl         = url('/returnFromfawry?order_id=' . $order_header->id . '&&platform=' . $platform);
            $fsbh              = $merchantCode . $merchantRefNum . $customerProfileId . $returnUrl . $itm . $merchant_sec_key;
            $signature         = hash('sha256', $fsbh);
            return view('fawry', compact('order', 'user', 'address', 'total_order', 'merchantRefNum', 'signature', 'amount', 'returnUrl', 'merchantCode'));
        }

    }

    public function returnFromfawry(Request $request)
    {
        $statusCode = $_GET['statusCode'];

        $platform = $_GET['platform'];
        if ($_GET['statusCode'] != '200') {
            $orderStatus       = isset($_GET['orderStatus']) ? $_GET['orderStatus'] : "UNPAID";
            $statusDescription = $_GET['statusDescription'];
            $id                = $_GET['order_id'];
            Session::flash('message', $statusDescription);
            if ($platform == 'admin') {
                return redirect(url('/admin/orderHeaders/create?message=' . $statusDescription));
            }
            return redirect()->route('paySuccess', ['id' => $id, 'statusDescription' => $statusDescription, 'statusCode' => $statusCode, 'orderStatus' => $orderStatus]);
        }
        elseif ($_GET['statusCode'] == '200') {
            $orderStatus       = isset($_GET['orderStatus']) ? $_GET['orderStatus'] : "PAID";
            $statusDescription = $_GET['statusDescription'];
            $merchantRefNumber = $_GET['merchantRefNumber'];
            $referenceNumber   = $_GET['referenceNumber'];
            $paymentMethod     = $_GET['paymentMethod'];
            $id                = $_GET['order_id'];

            $order_header = OrderHeader::select('id', 'total_order', 'shipping_amount', 'address_id')->where('id', $id)->first();
            $order        = DB::select('SELECT
       ol.price ,ol.quantity ,
       ol.product_id  "itemCode"
FROM order_lines ol
WHERE ol.order_id=' . $order_header->id . '
	                      ');

            $total_order = $order_header->total_order;
            $pprice      = $order_header->shipping_amount;
            $order[]     = (object)[
                'itemCode'    => $order_header->id,
                'price'       => $pprice,
                'description' => 'shipping Amount',
                'quantity'    => 1,
            ];

            $data = [
                "payment_number"         => $referenceNumber,
                "payment_status"         => $orderStatus,
                "payment_payment_method" => $paymentMethod,
                "payment_type"           => PaymentNames::FAWRY_PAYMENT,
                "orderItems"             => $order,
            ];

            $this->PaymentService->saveRequest($data);
            $this->PaymentService->updateOrderPaymentNumber($id, $referenceNumber);
            $orderHeaderId = $order_header->id;
            if ($orderHeaderId && $this->PaymentService->canChangeOrderStatus($orderHeaderId)) {
                $orderHeader = $this->OrderService->getOrderHeader($orderHeaderId);
                ($data['payment_status'] == OrderStatus::PAID) ? $this->PaymentService->payOrder($orderHeader, $data['payment_number']) : $this->PaymentService->expiredOrder($orderHeader);
                if ($platform == 'admin') {
                    return redirect(url('/admin/orderHeaders/create?message=' . $statusDescription));
                }
                return redirect()->route('paySuccess', ['id' => $id, 'statusDescription' => $statusDescription, 'statusCode' => $statusCode, 'orderStatus' => $orderStatus]);
            }
            if ($platform == 'admin') {
                return redirect(url('/admin/orderHeaders/create?message=' . $statusDescription));
            }
            return redirect()->route('paySuccess', ['id' => $id, 'statusDescription' => $statusDescription, 'statusCode' => $statusCode, 'orderStatus' => $orderStatus]);
        }
    }
}
