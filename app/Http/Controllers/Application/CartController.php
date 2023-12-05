<?php

namespace App\Http\Controllers\Application;

use App\Constants\OrderTypes;
use App\Http\Services\CartService;
use App\Http\Services\UserService;
use App\Libraries\ApiResponse;
use App\Libraries\ApiValidator;
use App\ValidationClasses\CartValidation;
use Illuminate\Http\Request;

class CartController extends  HomeController
{

    protected  $API_VALIDATOR;
    protected  $API_RESPONSE;
    protected  $CartValidation;
    protected  $CartService;
    protected  $UserService;

    public function __construct(ApiValidator  $apiValidator,ApiResponse  $API_RESPONSE,CartValidation $CartValidation,CartService $CartService,UserService $UserService)
    {
        $this->API_VALIDATOR=$apiValidator;
        $this->API_RESPONSE=$API_RESPONSE;
        $this->CartValidation=$CartValidation;
        $this->CartService=$CartService;
        $this->UserService=$UserService;
    }


    public function CalculateProductsAndShipping(Request  $request)
    {
        $validator=$this->API_VALIDATOR->validateWithNoToken($this->CartValidation->cartProducts());
        if ($validator) {
            $errorMessages=[];
            foreach ($validator->keys() as $error) {
                $errorMessages[] = trans('validation.'.$error);
            }
            return $this->API_RESPONSE->errors($errorMessages,400);
        }
        $data = [
            "user_id"             => $request->user_id,
            "created_for_user_id" => request()->input('created_for_user_id'),
            "order_type"          => request()->input('order_type'),
            "items"               => request()->input('items')
        ];
        $has_discount     = $this->UserService->userHasDiscount($data['created_for_user_id']);
        $this->CartService->orderType=$data['order_type'];
        $productsAndTotal = $this->CartService->calculateProducts($data["items"],$has_discount);

        if (!empty($productsAndTotal)) {
            $this->CartService->saveProductsToCart($productsAndTotal['products'],$data['user_id'],$data['created_for_user_id']);
            $productsAndTotal['shipping']         = $this->CartService->calculateShipping($data['created_for_user_id'],$data['order_type'],$productsAndTotal['totalProductsAfterDiscount']);
            $productsAndTotal['allowed_services'] = $this->CartService->getServices($productsAndTotal['totalProductsAfterDiscount'],$data['user_id']);
            $this->CartService->saveCartHeader($data['user_id'],$data['created_for_user_id'],$data['order_type'],$productsAndTotal['totalProducts'],$productsAndTotal['totalProductsAfterDiscount'],$productsAndTotal['shipping']);
            return $this->API_RESPONSE->data($productsAndTotal,'All Prices',200);
        }
        return  $this->API_RESPONSE->errors([trans('auth.error_on_create')],400);
    }

}
