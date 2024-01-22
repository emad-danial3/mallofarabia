<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use App\Http\Requests\ProductChangeStatusRequest;
use App\Http\Requests\ProductExportRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Services\CategoryService;
use App\Http\Services\CompanyService;
use App\Http\Services\ProductService;
use App\Models\Product;
use App\Models\Option;
use App\Models\OptionValue;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class ProductsController extends HomeController
{
    private $ProductService;
    private $CategoryService;
    private $CompanyService;

    public function __construct(ProductService  $ProductService,
                                CategoryService $CategoryService,
                                CompanyService  $CompanyService)
    {
        $this->ProductService = $ProductService;
        $this->CategoryService = $CategoryService;
        $this->CompanyService = $CompanyService;
    }

    public function index()
    {
        $data = $this->ProductService->getAll(request()->all());
        return view('AdminPanel.PagesContent.Products.index')->with('products', $data);
    }


    public function productsBarcode(Request $request)
    {

        return redirect('/');
        $name = $request->name;
        $barcode = $request->barcode;
        $oracle_short_code = $request->oracle_short_code;
        $data = null;

        if (isset($oracle_short_code)) {
            $data = Product::where('oracle_short_code', '=', $oracle_short_code)->first();
        }
        if (isset($name)) {
            $data = Product::where('name_en', 'like', '%' . $name . '%')->first();
        }
        if (isset($barcode)) {
            $data = Product::where('barcode', '=', $barcode)->first();
        }
        return view('AdminPanel.PagesContent.Products.barcode', compact('data'));
    }

    public function updateNewBarcode(Request $request)
    {
        $data = Product::where('id', $request->update_product_id)->first();
        if (!empty($data)) {
            $data->barcode = $request->newbarcode;
            $data->save();
            $response = [
                'status' => 200,
                'message' => "product update",
                'data' => $data
            ];
            return response()->json($response);
        } else {
            $response = [
                'status' => 401,
                'message' => "product not found",
                'data' => null
            ];
            return response()->json($response);
        }


    }


    public function create()
    {

        $categories = $this->CategoryService->getAllSubCategories();
        $companies = $this->CompanyService->getAll();
        $options = Option::all();
        return view('AdminPanel.PagesContent.Products.edit', compact('categories', 'companies', 'options'));
    }

    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();
        $this->ProductService->createRow($validated);
        return redirect()->route('products.index')->with('message', ' Product Created Successfully');
    }

    public function show(Product $product)
    {
        return view('AdminPanel.PagesContent.Products.show', compact('product'));
    }

    public function getOptionValues(Request $request)
    {
        $options = OptionValue::where('option_id', $request->id)->get();
        $response = [
            'status' => 200,
            'message' => "All Values",
            'data' => $options
        ];
        return response()->json($response);
    }

    public function getAllProductsToProgram(Request $request)
    {
        $data = $this->ProductService->getAll(request()->all());
        $response = [
            'status' => 200,
            'message' => "All products",
            'data' => $data
        ];
        return response()->json($response);
    }

    public function getOneProductToProgram(Request $request)
    {
        $data = Product::find(request()->id);
        $response = [
            'status' => 200,
            'message' => "One Product",
            'data' => $data
        ];
        return response()->json($response);
    }

    public function edit(Product $product)
    {
        if (Auth::guard('admin')->user()->role != 'cashier' && Auth::guard('admin')->user()->role != 'accountant') {
            $newCategories = $this->CategoryService->getAllSubCategories();
            $companies = $this->CompanyService->getAll();
            return view('AdminPanel.PagesContent.Products.edit', compact('product', 'newCategories', 'companies'));
        } else {
            return   $this->index();
        }

    }

    public function update(ProductRequest $request, $id)
    {
        
        $validated = $request->validated();
        $validated['updated_by'] = Auth::user()->id;
        $validated['updated_by_date'] = Carbon::now()->toDateTimeString();
        $this->ProductService->updateRow($validated, $id);
        return redirect()->back()->with('message', 'Product Updated Successfully');
    }

    public function destroy(Product $product)
    {

    }

    public function changeStatus(ProductChangeStatusRequest $request)
    {

        $inputData = $request->validated();
        $products_ids = explode(",", $inputData['products_ids']);
        if ($products_ids[0] == 'on')
            $products_ids[0] = 0;
        $stock_status = $inputData['stock_status'];
        $this->ProductService->changeStatus($products_ids, $stock_status);
        return redirect()->back()->with('message', 'Products Updated Successfully');
    }

    public function ExportProductsSheet(ProductExportRequest $request)
    {
        $inputData = $request->validated();

        if ($inputData['products_ids'] === "0") {

            try {
                return Excel::download(new ProductsExport($inputData['products_ids']), 'products.xlsx');

            } catch (\Exception $e) {
                return $e->getMessage();
            }

        } else {
            $products_ids = explode(",", $inputData['products_ids']);
            if ($products_ids[0] == 'on')
                $products_ids[0] = 0;
            return Excel::download(new ProductsExport($products_ids), 'products.xlsx');

        }

    }


}
