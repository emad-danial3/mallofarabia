<?php

namespace App\Http\Controllers\Admin;

use App\Http\Services\OracleProductService;
use App\Http\Services\ProductService;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Services\PaymentService;
use DB;

class OracleProductsController extends HomeController
{
    private   $ProductService;
    private   $OracleProductService;
    protected $PaymentService;

    public function __construct(ProductService $ProductService, PaymentService $PaymentService, OracleProductService $OracleProductService)
    {
        $this->ProductService       = $ProductService;
        $this->PaymentService       = $PaymentService;
        $this->OracleProductService = $OracleProductService;
    }


    public function index()
    {
        $data = $this->OracleProductService->getAll(request()->all());
        return json_encode($data);
    }

    public function updateProductsCodes()
    {


//        $affectedRows = Product::where('image','like','%version_2/public/images%')->limit(5)->offset(0)->get();
//        dd($affectedRows);
//         foreach ($affectedRows as $product)
//        {
//             $array        = explode('images/', $product->image);
//             $newimage='images/'.$array[1];
//             dd($newimage);
//             $product->image=$newimage;
//             $product->save();

//           $nfull_name1= trim($user->full_name);
//           $nfull_name= preg_replace('/\s{2}/s', ' ',$nfull_name1);
//            User::where('id', $user->id)->update(['full_name' =>$nfull_name]);
//        }

//        dd($affectedRows);
//        $affectedRows = User::all();
//        foreach ($affectedRows as $user)
//        {
//           $nfull_name1= trim($user->full_name);
//           $nfull_name= preg_replace('/\s{2}/s', ' ',$nfull_name1);
//            User::where('id', $user->id)->update(['full_name' =>$nfull_name]);
//        }
//dd('fggffg');
        $client   = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'https://sales.atr-eg.com/api/RefreshNettinghubItems.php', ['verify'      => false,
                                                                                                         'form_params' => array(
                                                                                                             'number' => '100',
                                                                                                             'name'   => 'Test user',
                                                                                                         )

        ]);
        $products = $response->getBody();

        if (isset($products)) {
            $products = json_decode($products);
            if (isset($products) && isset($products[0]) && !isset($products[0]->Message)) {
                $this->OracleProductService->truncateModel();
                foreach ($products as $product) {
                    $this->OracleProductService->createOrUpdate($product);
                }
                return redirect()->back()->with('message', "Items Updated  Successfully");
            }
             return redirect()->back()->withErrors(['error' => "error in get Data from oracle"]);
        }
        else {
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

    public function sendOrderToOracleThatNotSending()
    {
        $this->PaymentService->sendOrderToOracleThatNotSending();
    }

    public function sendOrderToOracleNotSending(Request $request)
    {
        $order_id = $request->input('order_id');
        $this->PaymentService->sendOrderToOracleNotSending($order_id);
        return redirect()->back()->with('message', "Order  Successfully");
    }

}
