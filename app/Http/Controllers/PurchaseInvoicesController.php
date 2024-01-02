<?php

namespace App\Http\Controllers;

use App\Exports\OrdersExport;
use App\Exports\OrderUserExport;
use App\Http\Requests\ExportOrderHeadersSheet;
use App\Http\Requests\ExportShippingSheetSheetRequest;
use App\Http\Requests\PurchaseInvoiceRequest;
use App\Http\Services\PurchaseInvoicesService;
use App\Http\Services\PurchaseInvoicesLinesService;
use App\Models\Area;
use App\Models\Company;
use App\Models\Option;
use App\Models\OrderHeader;
use App\Models\PurchaseInvoices;
use App\Models\OrderLine;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Services\CategoryService;
use App\Http\Services\CompanyService;
use Auth;

class PurchaseInvoicesController extends HomeController
{
    private $PurchaseInvoicesService;
    private $PurchaseInvoicesLinesService;
    private $CategoryService;
    private $CompanyService;

    public function __construct(PurchaseInvoicesService      $PurchaseInvoicesService,
                                CategoryService              $CategoryService,
                                CompanyService               $CompanyService,
                                PurchaseInvoicesLinesService $PurchaseInvoicesLinesService)
    {
        $this->PurchaseInvoicesService      = $PurchaseInvoicesService;
        $this->PurchaseInvoicesLinesService = $PurchaseInvoicesLinesService;
        $this->CategoryService              = $CategoryService;
        $this->CompanyService               = $CompanyService;
    }

    public function index()
    {
        $data = $this->PurchaseInvoicesLinesService->getAll(request()->all());
        return view('AdminPanel.PagesContent.PurchaseInvoices.index')->with('purchaseInvoices', $data);
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
        $companies = $this->CompanyService->getAll();
        return view('AdminPanel.PagesContent.PurchaseInvoices.form', compact('companies'));
    }


    public function getAllproducts(Request $request)
    {
        $inputData = $request;
        $products  = Product::select('products.id', 'products.flag', 'products.full_name', 'products.name_en', 'products.name_ar', 'products.description_en',
            'products.description_ar', 'products.image', 'products.oracle_short_code', 'products.discount_rate',
            'products.price', 'products.price_after_discount', 'products.quantity')
            ->where('products.stock_status', 'in stock')
            ->where('products.visible_status', '1');

        if (isset($inputData['name']) && $inputData['name'] != '') {
            $products->where('products.name_en', 'like', '%' . $inputData['name'] . '%')->orWhere('products.oracle_short_code', 'like', '%' . $inputData['name'] . '%');
        }

        if (isset($inputData['company_id']) && $inputData['company_id'] != '') {
            $products->where('products.flag', $inputData['company_id']);
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
        $user = User::where('full_name', request()->all()['name'])->first();
        if ($user) {
            $response = [
                'status'  => 200,
                'message' => "All Users",
                'data'    => $user->id
            ];
            return response()->json($response);
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


    public function CreatePurchaseInvoices(Request $request)
    {

        $data = [
            "company_id" => request()->input('company_id'),
            "items"      => request()->input('items')
        ];

        $productsAndTotal = $this->calculateTotalProducts($data["items"]);
        if (isset($productsAndTotal) && $productsAndTotal > 0) {

            $invoiceData = [
                'company_id'  => $data['company_id'],
                'user_id'     => Auth::user()->id,
                'total_price' => $productsAndTotal,
            ];
            $invoice     = PurchaseInvoices::create($invoiceData);

            if (!empty($invoice)) {
                $invoice['items_count'] = count($data['items']);
                $this->PurchaseInvoicesLinesService->createInvoiceLines($invoice['id'], $data['items']);
            }
            $response = [
                'status'  => 200,
                'message' => "invoice Created Successfully",
                'data'    => $invoice
            ];
            return response()->json($response);

        }
        $response = [
            'status'  => 200,
            'message' => "error in create",
            'data'    => null
        ];
        return response()->json($response);
    }


    public function calculateTotalProducts($items)
    {
        $totalProducts = 0;
        foreach ($items as $item) {
            $totalProducts += ((floatval($item['purchase_price'])) * intval($item['quantity']));
        }
        return $totalProducts;
    }

    public function store(PurchaseInvoiceRequest $request)
    {
        $validated = $request->validated();
        $this->PurchaseInvoicesLinesService->createInvoiceLines($validated);
        return redirect()->route('purchaseInvoices.index')->with('message', ' Product Created Successfully');
    }

    public function show(OrderHeader $orderHeader)
    {
        $orderNumber        = $orderHeader->id;
        $invoicesCount      = OrderLine::select('oracle_num')->where('order_id', $orderNumber)->distinct()->count('oracle_num');
        $invoicesNumber     = OrderLine::select('oracle_num')->where('order_id', $orderNumber)->distinct()->get();
        $invoicesLines      = DB::select('SELECT ol.oracle_num ,p.price pprice,p.tax ptax,ol.price olprice,p.name_en psku,ol.quantity olquantity FROM order_lines ol,products p
     	                        where 	ol.order_id =' . $orderNumber . '
     	                        and ol.product_id = p.id ');
        $invoicesTotalPrice = OrderLine::where('order_id', $orderNumber)->sum('quantity');
        $user               = User::where('id', $orderHeader->created_for_user_id)->first();
        return view('AdminPanel.PagesContent.OrderHeaders.show', compact('orderHeader', 'invoicesNumber', 'invoicesCount', 'invoicesLines', 'invoicesTotalPrice', 'user'));
    }

    public function edit(OrderHeader $orderHeader)
    {
        $orderNumber        = $orderHeader->id;
        $invoicesCount      = OrderLine::select('oracle_num')->where('order_id', $orderNumber)->distinct()->count('oracle_num');
        $invoicesNumber     = OrderLine::select('oracle_num')->where('order_id', $orderNumber)->distinct()->get();
        $invoicesLines      = DB::select('SELECT ol.product_id, ol.oracle_num ,p.price pprice,p.tax ptax,ol.price olprice,p.name_en psku,ol.quantity olquantity FROM order_lines ol,products p
     	                        where 	ol.order_id =' . $orderNumber . '
     	                        and ol.product_id = p.id ');
        $invoicesTotalPrice = OrderLine::where('order_id', $orderNumber)->sum('quantity');
        $user               = User::where('id', $orderHeader->created_for_user_id)->first();

        return view('AdminPanel.PagesContent.OrderHeaders.refund', compact('orderHeader', 'invoicesNumber', 'invoicesCount', 'invoicesLines', 'invoicesTotalPrice', 'user'));

    }


    public function update(Request $request, OrderHeader $orderHeader)
    {}

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

    public function reports(Request $inputData)
    {
       $inputData=request()->all();
        $purchaseInvoiceLines = DB::table('purchase_invoice_lines')
            ->leftJoin('companies', 'companies.id', '=', 'purchase_invoice_lines.flag')
            ->leftJoin('products', 'products.oracle_short_code', '=', 'purchase_invoice_lines.oracle_short_code')
            ->groupBy('purchase_invoice_lines.oracle_short_code')
            ->select('purchase_invoice_lines.id', 'purchase_invoice_lines.oracle_short_code', DB::raw("count(purchase_invoice_lines.id) AS  lines_count"), DB::raw("sum(purchase_invoice_lines.price) AS  total_purchase_price"), DB::raw("sum(purchase_invoice_lines.quantity) AS  total_purchase_quantity"), 'companies.name_en', 'products.full_name', 'purchase_invoice_lines.price', 'purchase_invoice_lines.quantity', 'purchase_invoice_lines.created_at');

        if (isset($inputData['name'])) {
            $purchaseInvoiceLines->where('purchase_invoice_lines.id', $inputData['name']);
        }
        if (isset($inputData['product_name'])) {
            $purchaseInvoiceLines->where('products.full_name', 'like', '%' . $inputData['product_name'] . '%');
        } if (isset($inputData['product_code'])) {
            $purchaseInvoiceLines->where('purchase_invoice_lines.oracle_short_code', 'like', '%' . $inputData['product_code'] . '%');
        }
        if (isset($inputData['from_date']) && isset($inputData['to_date'])) {
            $purchaseInvoiceLines->whereBetween('purchase_invoice_lines.created_at', [$inputData['from_date'], $inputData['to_date']]);
        }
     $purchaseInvoiceLines=$purchaseInvoiceLines->paginate(30);

        return view('AdminPanel.PagesContent.PurchaseInvoices.reports')->with('purchaseInvoiceLines', $purchaseInvoiceLines);
    }

}
