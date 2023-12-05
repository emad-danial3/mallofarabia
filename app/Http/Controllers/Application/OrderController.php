<?php

namespace App\Http\Controllers\Application;

use App\Http\Services\CartService;
use App\Http\Helpers\StockManagement;
use App\Http\Services\OrderLinesService;
use App\Http\Services\OrderService;
use App\Http\Services\ProductService;
use App\Http\Services\UserService;
use App\Libraries\ApiResponse;
use App\Libraries\ApiValidator;
use App\ValidationClasses\OrderValidation;
use Illuminate\Http\Request;

class OrderController extends  HomeController
{
    use StockManagement;
    protected  $API_VALIDATOR;
    protected  $API_RESPONSE;
    protected  $OrderValidation;
    protected  $OrderService;
    protected  $UserService;
    protected  $OrderLinesService;
    protected  $CommissionService;
    protected  $CartService;
    protected  $ProductService;

    public function __construct(ApiValidator  $apiValidator,ApiResponse  $API_RESPONSE,OrderService  $OrderService,
                                OrderValidation $OrderValidation,UserService  $UserService
                              ,OrderLinesService $OrderLinesService ,

                                CartService $CartService,
                                ProductService $ProductService
                                )
    {
        $this->API_VALIDATOR     = $apiValidator;
        $this->API_RESPONSE      = $API_RESPONSE;
        $this->OrderService      = $OrderService;
        $this->OrderValidation   = $OrderValidation;
        $this->UserService       = $UserService;
        $this->OrderLinesService = $OrderLinesService;
        $this->CartService       = $CartService;
        $this->ProductService    = $ProductService;
    }

    public function createOrder(Request  $request)
    {
        $validator=$this->API_VALIDATOR->validateWithNoToken($this->OrderValidation->createOrder());
        $validator2=[];
        $address_is_changed=request()->input('address_is_changed');
        if ($address_is_changed==1)
        {
            $validator2=$this->API_VALIDATOR->validateWithNoToken($this->OrderValidation->validateAddress());
        }
        if ($validator) {
            $errorMessages=[];
            foreach ($validator->keys() as $error) {
                $errorMessages[] = trans('validation.'.$error);
            }
            return $this->API_RESPONSE->errors($errorMessages,400);
        }
        if ($validator2) {
            $errorMessages=[];
            foreach ($validator2->keys() as $error) {
                $errorMessages[] = trans('validation.'.$error);
            }
            return $this->API_RESPONSE->errors($errorMessages,400);
        }
        $data = [
          'user_id'             => $request->user_id,
          'created_for_user_id' => $request->input('created_for_user_id'),
          'order_type'          => $request->input('order_type'),
        ];

        $userAddress = ($address_is_changed)? $this->UserService->getAddressInfo(request()->all()) : $this->UserService->getUserAddress(request()->input('created_for_user_id'));
        $orderHeader=$this->OrderService->createOrderHeader($data, $userAddress);
        if (!empty($orderHeader))
        {
            $this->OrderLinesService->createOrderLines($orderHeader['id'] , $data['user_id'], $data['created_for_user_id']);
            $this->CommissionService->createCommission($orderHeader);
            $this->OrderLinesService->deleteCartAndCartHeader($data['user_id'], $data['created_for_user_id']);
            return  $this->API_RESPONSE->data(['order_header'=>$orderHeader],trans('auth.order_created'),201);
        }
        return  $this->API_RESPONSE->errors([trans('auth.error_on_create')],400);
    }

    public function updatePaymentCode(Request  $request)
    {
        $validator = $this->API_VALIDATOR->validateWithNoToken($this->OrderValidation->updatePaymentCodeRules());
        if ($validator) {
            $errorMessages=[];
            foreach ($validator->keys() as $error) {

                $errorMessages[] = trans('validation.'.$error);
            }
            return $this->API_RESPONSE->errors($errorMessages,400);
        }
        $order_id = $request->input('id');
        $payment_code = $request->input('payment_code');
        $this->OrderService->updatePaymentCode($order_id, $payment_code);
        return $this->API_RESPONSE->success( trans('auth.order_updated'),201);
    }

    public function myOrder(Request  $request)
    {
        $validator = $this->API_VALIDATOR->validateWithNoToken($this->OrderValidation->myOrder());
        if ($validator) {
            $errorMessages=[];
            foreach ($validator->keys() as $error) {
                $errorMessages[] = trans('validation.'.$error);
            }
            return $this->API_RESPONSE->errors($errorMessages,400);
        }

        $user_id   = $request->user_id;
        $my_orders  = $this->OrderService->getMyOrder($user_id);
        return $this->API_RESPONSE->data(['my_orders' => $my_orders ],'My Orders',200);
    }
     public function getOrderDetails(Request  $request)
    {
        $validator = $this->API_VALIDATOR->validateWithNoToken(['order_id' => 'required']);
        if ($validator) {
            $errorMessages=[];
            foreach ($validator->keys() as $error) {
                $errorMessages[] = trans('validation.'.$error);
            }
            return $this->API_RESPONSE->errors($errorMessages,400);
        }
        $my_order  = $this->OrderService->getMyOrderDetails($request->order_id);
        return $this->API_RESPONSE->data($my_order,'My Order Detail',200);
    }
     public function cancelOrder(Request  $request)
    {
        $validator = $this->API_VALIDATOR->validateWithNoToken(['order_id' => 'required']);
        if ($validator) {
            $errorMessages=[];
            foreach ($validator->keys() as $error) {
                $errorMessages[] = trans('validation.'.$error);
            }
            return $this->API_RESPONSE->errors($errorMessages,400);
        }
        $my_order  = $this->OrderService->cancelOrder($request->order_id);
        return $this->API_RESPONSE->data($my_order,'My Order Canceled',200);
    }

    public function orderDetails(Request  $request)
    {
        $validator = $this->API_VALIDATOR->validateWithNoToken($this->OrderValidation->orderDetailRules());
        if ($validator) {
            $errorMessages=[];
            foreach ($validator->keys() as $error) {

                $errorMessages[] = trans('validation.'.$error);
            }
            return $this->API_RESPONSE->errors($errorMessages,400);
        }
        $my_orders  = $this->OrderService->getMyOrderDetails($request->input('id'));
        return $this->API_RESPONSE->data(['my_order_detail' => $my_orders ],'My Order Detail',200);
    }

    public function reorder(Request  $request)
    {
        $validator = $this->API_VALIDATOR->validateWithNoToken($this->OrderValidation->reorderRules());
        if ($validator) {
            $errorMessages=[];
            foreach ($validator->keys() as $error) {

                $errorMessages[] = trans('validation.'.$error);
            }
            return $this->API_RESPONSE->errors($errorMessages,400);
        }

        $items   =  $request->input('items');
        $user_id = $request->user_id;
        $userHasDiscount     = $this->UserService->userHasDiscount($user_id);
        $productsAndTotal = $this->CartService->calculateProducts($items, $userHasDiscount);

        $is_changed = (int)(count($productsAndTotal['products']) != count($items));
        return $this->API_RESPONSE->data(['reorder_products' => $productsAndTotal , 'is_changed' => $is_changed ],'Reorder Products',200);
    }

    public function changeOrderStatus(Request  $request){

    }
}
