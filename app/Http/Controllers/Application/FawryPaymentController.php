<?php

namespace App\Http\Controllers\Application;

use App\Constants\OrderStatus;
use App\Constants\PaymentNames;
use App\Http\Services\FawryPaymentService;
use App\Http\Services\OrderService;
use App\Http\Services\PaymentService;
use App\Libraries\ApiResponse;
use App\Libraries\ApiValidator;
use App\ValidationClasses\FawryPaymentValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use App\Http\Services\OrderLinesService;

class FawryPaymentController extends HomeController
{
    private  $API_VALIDATOR;
    private  $API_RESPONSE;
    private  $FawryPaymentValidation;
    private  $PaymentService;
    private  $OrderService;
     protected $OrderLinesService;

    public function __construct(ApiValidator $apiValidator, ApiResponse $API_RESPONSE,
                                FawryPaymentValidation $FawryPaymentValidation,
                                PaymentService $PaymentService
        , OrderLinesService $OrderLinesService,

                                OrderService $OrderService)
    {
        $this->API_VALIDATOR           = $apiValidator;
        $this->API_RESPONSE            = $API_RESPONSE;
        $this->FawryPaymentValidation  = $FawryPaymentValidation;
        $this->PaymentService          = $PaymentService;
        $this->OrderService            = $OrderService;
                $this->OrderLinesService  = $OrderLinesService;
    }

    public function changeOrderStatus(Request  $request)
    {

        $validator=$this->API_VALIDATOR->validateWithNoToken($this->FawryPaymentValidation->payOrder());
        if ($validator) {
            $errorMessages=[];
            foreach ($validator->keys() as $error) {
                $errorMessages[] = trans('validation.'.$error);
            }
            return $this->API_RESPONSE->errors($errorMessages,400);
        }

        $data = [
            "payment_number" => $request->input('fawryRefNumber'),
            "payment_status" => $request->input('orderStatus'),
            "payment_payment_method" => $request->input('paymentMethod'),
            "payment_type" => PaymentNames::FAWRY_PAYMENT,
            "orderItems" => $request->input('orderItems'),
        ];

        Log::info('fawry Pay load 4u',$data);

        $this->PaymentService->saveRequest($data);

        $orderHeaderId = $this->PaymentService->findOrderHeaderId($data['orderItems']);
        $this->PaymentService->updateOrderPaymentNumber($orderHeaderId,$request->input('fawryRefNumber'));
        if ($orderHeaderId && $this->PaymentService->canChangeOrderStatus($orderHeaderId))
        {
            $orderHeader = $this->OrderService->getOrderHeader($orderHeaderId);
             $this->OrderLinesService->deleteCartAndCartHeader($orderHeader->user_id, $orderHeader->user_id);
            ($data['payment_status'] == OrderStatus::PAID)? $this->PaymentService->payOrder($orderHeader,$data['payment_number']):$this->PaymentService->expiredOrder($orderHeader);
            return $this->API_RESPONSE->success('Order PAID',201);
        }
        return $this->API_RESPONSE->errors([trans('auth.validation.error_on_create')],400);
    }

      public function changeOrderStatusFromOldProject(Request  $request)
    {

        $data = [
            "payment_number" => $request->input('payment_number'),
            "payment_status" => $request->input('payment_status'),
            "payment_payment_method" => $request->input('payment_payment_method'),
            "payment_type" => PaymentNames::FAWRY_PAYMENT,
            "orderItems" => $request->input('orderItems'),
        ];

        Log::info('fawry Pay load 4u',$data);

        $this->PaymentService->saveRequest($data);

        $orderHeaderId = $this->PaymentService->findOrderHeaderId($data['orderItems']);
        $this->PaymentService->updateOrderPaymentNumber($orderHeaderId,$request->input('payment_number'));
        if ($orderHeaderId && $this->PaymentService->canChangeOrderStatus($orderHeaderId))
        {
            $orderHeader = $this->OrderService->getOrderHeader($orderHeaderId);
            ($data['payment_status'] == OrderStatus::PAID)? $this->PaymentService->payOrder($orderHeader,$data['payment_number']):$this->PaymentService->expiredOrder($orderHeader);
            return $this->API_RESPONSE->success('Order PAID',201);
        }
        return $this->API_RESPONSE->errors([trans('auth.validation.error_on_create')],400);
    }

}
