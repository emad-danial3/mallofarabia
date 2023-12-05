<?php

namespace App\Http\Controllers\Application;

use App\Http\Services\ProductService;
use App\Http\Services\UserService;
use App\Libraries\ApiResponse;
use App\Libraries\ApiValidator;
use App\ValidationClasses\ProductsValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ProductController extends HomeController
{
    protected $API_VALIDATOR;
    protected $API_RESPONSE;
    protected $ProductsValidation;
    protected $ProductService;
    protected $UserService;

    public function __construct(UserService $UserService, ProductService $ProductService, ApiValidator $apiValidator, ApiResponse $API_RESPONSE, ProductsValidation $ProductsValidation)
    {
        $this->API_VALIDATOR      = $apiValidator;
        $this->API_RESPONSE       = $API_RESPONSE;
        $this->ProductsValidation = $ProductsValidation;
        $this->ProductService     = $ProductService;
        $this->UserService        = $UserService;
    }

    public function getAllProducts(Request $request)
    {
        $validator = $this->API_VALIDATOR->validateWithNoToken($this->ProductsValidation->getAllProducts());
        // if ($validator) {
        //     $errorMessages=[];
        //     foreach ($validator->keys() as $error) {
        //         $errorMessages[] = trans('validation.'.$error);
        //     }
        //     return $this->API_RESPONSE->errors($errorMessages,400);
        // }

        $products       = $this->ProductService->getAllProducts(request()->all());
        $userFavourites = $this->UserService->getUserFavourites(['user_id', $request->user_id]);
        $products       = $this->productInFavourite($products, $userFavourites);
        return $this->API_RESPONSE->data(['products' => $products, 'NextOffset' => $this->ProductService->getNextOffset()], 'All Products', 200);
    }
    public function getBestProducts(Request $request)
    {
        $products       = $this->ProductService->getBestProducts(request()->all());
        $userFavourites = $this->UserService->getUserFavourites(['user_id', $request->user_id]);
        $products       = $this->productInFavourite($products, $userFavourites);
        return $this->API_RESPONSE->data(['products' => $products, 'NextOffset' => $this->ProductService->getNextOffset()], 'All Best Products', 200);
    }

    public function productInFavourite($products, $userFavourites)
    {
        $userFavouritesIds = [];
        if (isset($userFavourites) && !empty($userFavourites)) {
            foreach ($userFavourites as $one) {
                array_push($userFavouritesIds, $one->product_id);
            }
        }
        foreach ($products as $product) {
            $product->in_favourite =in_array($product->id,$userFavouritesIds);
        }
        return $products;
    }


}
