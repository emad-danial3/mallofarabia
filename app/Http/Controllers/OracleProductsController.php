<?php

namespace App\Http\Controllers;

use App\Http\Services\OracleProductService;
use App\Http\Services\ProductService;
use App\Models\Product;
use App\Models\User;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
class OracleProductsController extends HomeController
{
    private   $ProductService;
    private   $OracleProductService;

    public function __construct(ProductService $ProductService , OracleProductService $OracleProductService)
    {
        $this->ProductService       = $ProductService;
        $this->OracleProductService = $OracleProductService;
    }


    public function index()
    {
        $data = $this->OracleProductService->getAll(request()->all());
        return json_encode($data);
    }
    public function update_all()
    {



        $link = config('constants.refresh_mall_items');
        $client   = new \GuzzleHttp\Client();
        $response = $client->request('POST', $link,
        ['verify'      => false
        ]);

        $result = $response->getBody();

        if (isset($result))
        {
            $result = json_decode($result);
            if(isset($result[0]) && isset($result[0]->Message))
            {
                return redirect()->back()->withErrors(['error' => "error in get Data from oracle"]);
            }

                $this->OracleProductService->truncateModel();

                foreach ($result as $product)
                {
                    $this->OracleProductService->createOrUpdate($product);
                }

                $this->OracleProductService->updatePrices();
                $last_update = SiteSetting::where('name','products_last_updated')->first();
                $now = Carbon::now()->toDateTimeString();
                $last_update->value = $now ;
                $last_update->save();

                 session(['products_updated_today' => true]);
                 session(['products_last_updated' => $now]);
                return redirect()->back()->with('message', "Items Updated  Successfully");


        }
        else
        {
            return redirect()->back()->withErrors(['error' => "error in get Data"]);
        }

    }
    public function updateProductsCodes()
    {

        $link = config('constants.refresh_mall_items');
        $client   = new \GuzzleHttp\Client();
        $response = $client->request('POST', $link,
        ['verify'      => false
        ]);

        $result = $response->getBody();

        if (isset($result))
        {
            $result = json_decode($result);
            if(isset($result[0]) && $result[0]->Message)
            {
                return redirect()->back()->withErrors(['error' => "error in get Data from oracle"]);
            }

               // $this->OracleProductService->truncateModel();
                foreach ($result as $product)
                {
                    $this->OracleProductService->createOrUpdate($product);
                }
                return redirect()->back()->with('message', "Items Updated  Successfully");


        }
        else
        {
            return redirect()->back()->withErrors(['error' => "error in get Data"]);
        }
    }

    public function updateTableJS(Request $request)
    {

        $products = $request->input('myData');
        if (isset($products)) {
            $products = json_decode($products);
            foreach ($products as $product) {
                $this->OracleProductService->createOrUpdate($product);
            }
            return "Items Updated  Successfully";
        }
    }

    public function updateProductsPrice()
    {
        $this->OracleProductService->updatePrices();
        return redirect()->back()->with('message', "Items Prices Updated  Successfully");
    }

    public function getOracleProduct()
    {
        $data = $this->OracleProductService->find(request()->id);
        return json_encode($data);
    }

    public function updateProductsPriceOraclelJob()
    {
        $this->updateProductsCodes();
        $this->updateProductsPrice();
    }




}
