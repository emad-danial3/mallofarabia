<?php

namespace App\Http\Controllers\Application;

use App\Constants\PaymentNames;
use App\Http\Services\CartService;
use App\Http\Services\OrderLinesService;
use App\Http\Services\OrderService;
use App\Http\Services\PaidOrderActions\SingleOrderPaidActions;
use App\Http\Services\PaymentService;
use App\Http\Services\UserService;
use App\Libraries\ApiResponse;
use App\Libraries\ApiValidator;
use App\ValidationClasses\FawryPaymentValidation;
use App\ValidationClasses\OrderValidation;
use App\ValidationClasses\PayByWalletValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use function Composer\Autoload\includeFile;

class PayByWalletController extends  HomeController
{
    private  $API_VALIDATOR;
    private  $API_RESPONSE;
    private  $OrderService;
    private  $PayByWalletValidation;
    private  $OrderValidation;
    private  $UserService;

    private  $OrderLinesService;

    private  $CartService;
    private $SingleOrderPaidActions;

    public function __construct(ApiValidator          $apiValidator, ApiResponse $API_RESPONSE,
                                PaymentService        $PaymentService,
                                OrderService          $OrderService,
                                PayByWalletValidation $PayByWalletValidation,
                                OrderValidation       $OrderValidation,
                                UserService           $UserService,

                                OrderLinesService $OrderLinesService,

                                SingleOrderPaidActions      $SingleOrderPaidActions,

                                CartService  $CartService)
    {
        $this->API_VALIDATOR         = $apiValidator;
        $this->API_RESPONSE          = $API_RESPONSE;
        $this->PaymentService        = $PaymentService;
        $this->OrderService          = $OrderService;
        $this->PayByWalletValidation = $PayByWalletValidation;
        $this->OrderValidation       = $OrderValidation;
        $this->UserService           = $UserService;

        $this->OrderLinesService     = $OrderLinesService;
        $this->CartService           = $CartService;
        $this->SingleOrderPaidActions            = $SingleOrderPaidActions;

    }

    public function payByWallet(Request  $request)
    {
        $validator=$this->API_VALIDATOR->validateWithNoToken($this->PayByWalletValidation->payByWalletOrder());
        $validator2=[];
        $address_is_changed=request()->input('address_is_changed');
        if ($address_is_changed==1)
        {
            $validator2=$this->API_VALIDATOR->validateWithNoToken($this->OrderValidation->validateAddress());
        }
        if ($validator) {
            $errorMessages=[];
            foreach ($validator->keys() as $error) {
                $errorMessages[] =$error ;
            }
            return $this->API_RESPONSE->errors($errorMessages,400);
        }
        if ($validator2) {
            $errorMessages=[];
            foreach ($validator2->keys() as $error) {
                $errorMessages[] = $error;
            }
            return $this->API_RESPONSE->errors($errorMessages,400);
        }

        $data = [
            'user_id'             => $request->user_id,
            "created_for_user_id" => $request->input('created_for_user_id'),
            "order_type"          => $request->input('order_type'),
        ];
        $user=$this->UserService->getUser($data['user_id']);

//        Log::info('user1',['user'=>$user]);
        $walletAmount = $this->UserWalletRepository->getCurrentWallet($data['user_id']);

        if (!empty($walletAmount) && $walletAmount['current_wallet'] > 0)
        {

            $userAddress = ($address_is_changed)? $this->UserService->getAddressInfo(request()->all()) : $this->UserService->getUserAddress(request()->input('created_for_user_id'));
//            Log::info('user2',['user'=>$this->UserService->getUser($data['user_id'])]);

            $wallet_status   = $this->UserWalletService->applyWalletPay($data,$walletAmount);
//            Log::info('user3',['user'=>$this->UserService->getUser($data['user_id'])]);

            if ($wallet_status['type'] == "part")
           {
                // create header and lines and commissions
               $data['wallet_used_amount'] = $wallet_status['wallet_used_amount'];
               $data['wallet_status']      = "part_wallet";
               $orderHeader=$this->OrderService->createOrderHeaderForWallet($data, $userAddress);
               if (!empty($orderHeader))
               {
                   $this->OrderLinesService->createOrderLines($orderHeader['id'] , $data['user_id'], $data['created_for_user_id']);
                   $this->CommissionService->createCommission($orderHeader);
                   $CartItems = $this->CartService->getMyCart($data['user_id'],$data['created_for_user_id']);
                   $this->OrderLinesService->deleteCartAndCartHeader($data['user_id'], $data['created_for_user_id']);
                   $this->UserWalletService->updateWallet($data['user_id'],['current_wallet' =>  $wallet_status['rested_amount']]);
                   return  $this->API_RESPONSE->data(['order_header'=>$orderHeader,'products' =>$CartItems],trans('auth.order_created'),201);
               }

           }
           elseif ($wallet_status['type'] == "full")
           {

               $walletsEvaluationForOrder  = $this->WalletEvaluationRepository->find(1,  ['value', 'amount']);

               // create header and lines and commissions  and pay
               $data['wallet_used_amount'] = $wallet_status['wallet_used_amount'];
               $data['wallet_status']      = "full_wallet";
               $data['payment_status']      = "PAID";
               $data['gift_category_id']      = 10;
               $orderHeader=$this->OrderService->createOrderHeaderForWallet($data, $userAddress);
//               Log::info('user4',['user'=>$this->UserService->getUser($data['user_id'])]);

//               return $this->API_RESPONSE->data($userAddress,'test',201);

               if (!empty($orderHeader))
               {

                   $this->OrderLinesService->createOrderLines($orderHeader['id'] , $data['user_id'], $data['created_for_user_id']);
//                   Log::info('user5',['user'=>$this->UserService->getUser($data['user_id'])]);

                   $this->CommissionService->createCommission($orderHeader);
//                   Log::info('user6',['user'=>$this->UserService->getUser($data['user_id'])]);

                   $this->CommissionService->updateCommission(['order_id'=>$orderHeader['id']],['is_paid'=>1]);
//                   Log::info('user7',['user'=>$this->UserService->getUser($data['user_id'])]);

                   $this->OrderLinesService->deleteCartAndCartHeader($data['user_id'], $data['created_for_user_id']);
//                   Log::info('user8',['user'=>$this->UserService->getUser($data['user_id'])]);

                   $this->UserWalletService->updateWallet($data['user_id'],['current_wallet' =>  $wallet_status['rested_amount']]);
//                   Log::info('user9',['user'=>$this->UserService->getUser($data['user_id'])]);

                   $this->SingleOrderPaidActions->addOrderToMyWallet($orderHeader['created_for_user_id'],$walletsEvaluationForOrder,$orderHeader['total_order']);
                   $this->SingleOrderPaidActions->addOrderToMyParentWallet($orderHeader['created_for_user_id'],$walletsEvaluationForOrder,$orderHeader['total_order'],$orderHeader['id']);

                   $this->SingleOrderPaidActions->sendCommissionEmail($orderHeader['created_for_user_id']);
//                   Log::info('user10',['user'=>$this->UserService->getUser($data['user_id'])]);

                   $this->UserService->updateUserProfile(['device_id'=>$user['device_id']],$request->user_id);
//                   Log::info('user11',['user'=>$this->UserService->getUser($data['user_id'])]);

                   $this->SingleOrderPaidActions->sendCommissionMessage($orderHeader['created_for_user_id']);
//                   $this->SingleOrderPaidActions->sendOrderToOracle($orderHeader['id']);
                   return  $this->API_RESPONSE->data(['order_header'=>$orderHeader],trans('auth.order_created'),201);
               }
           }
           else
           {
               return  $this->API_RESPONSE->errors([trans('auth.error_on_create')],400);
           }
        }

    }
}
