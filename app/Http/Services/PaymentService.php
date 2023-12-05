<?php

namespace App\Http\Services;

use App\Constants\OrderStatus;
use App\Constants\OrderTypes;
use App\Constants\PaymentNames;
use App\Http\Controllers\Application\UserDashboardController;

use App\Http\Repositories\OrderRepository;
use App\Http\Repositories\PaymentLogRepository;
use App\Http\Services\PaidOrderActions\SingleOrderPaidActions;
use App\Http\Repositories\IUserRepository;
use App\Models\OrderHeader;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

class PaymentService extends BaseServiceController
{
    private   $PaymentLogRepository;
    private   $OrderHeaderRepository;

    private   $OrderRepository;
    private   $UserRepository;

    private   $UserDashboardController;
    private   $ProductService;
    protected $CartService;

    public function __construct(PaymentLogRepository   $PaymentLogRepository,
                                CartService            $CartService,
                                OrderRepository        $OrderRepository,
                                OrderRepository        $OrderHeaderRepository,
                                SingleOrderPaidActions $SingleOrderPaidActions,
                                IUserRepository        $UserRepository,
                                UserDashboardController      $UserDashboardController,
                                ProductService         $ProductService)

    {
        $this->PaymentLogRepository   = $PaymentLogRepository;
        $this->OrderHeaderRepository  = $OrderHeaderRepository;
        $this->SingleOrderPaidActions = $SingleOrderPaidActions;
        $this->OrderRepository        = $OrderRepository;
        $this->UserRepository         = $UserRepository;
        $this->UserDashboardController      = $UserDashboardController;
        $this->ProductService         = $ProductService;
        $this->CartService            = $CartService;
    }

    public function saveRequest($paymentData)
    {
        $paymentData['orderItems'] = json_encode($paymentData['orderItems'], true);
        $this->PaymentLogRepository->create($paymentData);
    }

    public function findOrderHeaderId($orderItems)
    {
        $idds = [];
        foreach ($orderItems as $product) {
            array_push($idds, $product['itemCode']);
            if (strpos($product['itemCode'], PaymentNames::ORDER_HEADER_ID_SUB_STRING) !== false) {
                $order = explode("-", $product['itemCode']);
                return $order[1];
            }
        }
        $orderh = OrderHeader::whereIn('id', $idds)->first();
        if ($orderh) {
            return $orderh->id;
        }
        else {
            $lastItem = end($orderItems);
            return $lastItem['itemCode'];
        }
    }

    public function canChangeOrderStatus($order_id): int
    {
        $orderHeader = $this->OrderHeaderRepository->find($order_id, ['payment_status']);
        if (!empty($orderHeader) && $orderHeader->payment_status == OrderStatus::PENDING)
            return 1;
        return 0;
    }

    public function payOrder($orderHeader, $payment_code = null)
    {
        $this->sendOrderToOracle($orderHeader['id']);
        if (isset($orderHeader['id']) && $orderHeader['id'] > 0) {
            $this->ProductService->updateOrderProductQuntity($orderHeader['id']);
            $this->CommissionService->createCommission($orderHeader);
            $this->UserDashboardController->calculateMyMonthlyCommission($orderHeader['user_id']);
            $this->UserDashboardController->calculateToMyParentMonthlyCommission($orderHeader['user_id']);
        }
        $this->OrderHeaderRepository->updateOrder(['id' => $orderHeader['id']], ['payment_status' => OrderStatus::PAID, 'payment_code' => $payment_code]);
    }

    public function expiredOrder($orderHeader)
    {
        if ($orderHeader['wallet_used_amount'] > 0) {
            $this->OrderHeaderRepository->updateOrder(['id' => $orderHeader['id']], ['payment_status' => OrderStatus::DELETED]);
            $this->UserWalletRepository->updateWalletWhenExpired($orderHeader['user_id'], $orderHeader['wallet_used_amount']);
        }
        $this->OrderHeaderRepository->updateOrder(['id' => $orderHeader['id']], ['payment_status' => OrderStatus::EXPIRED]);
    }

    public function updateOrderPaymentNumber($order_header_id, $payment_code)
    {
        $this->OrderHeaderRepository->updateOrder(['id' => $order_header_id], ['payment_code' => $payment_code]);
    }

//calculateMinRequired
    public function sendOrderToOracle($order_id)
    {

        $OrderLines                 = $this->OrderRepository->getOrder($order_id);
        $user_id                    = OrderHeader::where('id', $order_id)->first()['user_id'];
        $total_order_has_commission = OrderHeader::where('id', $order_id)->first()['totalProducts'];
        $hasDiscount                = 0;
        $currentuser                = User::find($user_id);
        if (!empty($currentuser)) {
            $hasDiscount          = $currentuser->stage == 2 ? 1 : 0;
            $discountLevel        = $this->CartService->getOrderDiscount($total_order_has_commission);
            $discountCosmeticFood = 0;
            $discountNotCosmetic  = 0;
            if (!empty($discountLevel)) {
                $discountNotCosmetic  = (float)$discountLevel->monthly_immediate_discount;
                $discountCosmeticFood = (float)$discountLevel->food_discount;
            }
        }


        $newValue    = [];
        $paymentCode = [];
        $max         = 0;

        if (count($OrderLines) > 0) {
            foreach ($OrderLines as $orderLine) {

                if (!array_key_exists($orderLine->payment_code, $paymentCode)) {
                    $max                                       += 1;
                    $OrderTypesArray[$orderLine->payment_code] = $max;
                }
                else {
                    $orderLine->has_free_product = 0;
                }

                if ($hasDiscount == 1) {
                    if ($orderLine->excluder_flag == 'Y') {
                        $orderLine->offer_flag = '0';
                    }
                    elseif (isset($orderLine->is_gift) && $orderLine->is_gift > 0) {
                        if ($orderLine->discount_rate == 70) {
                            $orderLine->offer_flag = '28';
                        }
                        elseif ($orderLine->discount_rate == 75) {
                            $orderLine->offer_flag = '29';
                        }
                        elseif ($orderLine->discount_rate == 80) {
                            $orderLine->offer_flag = '30';
                        }
                        else {
                            $orderLine->offer_flag = '0';
                        }
                    }
                    else {
                        if ($orderLine->flag == 5 || $orderLine->flag == 9) {
                            if ($discountCosmeticFood == 10) {
                                $orderLine->offer_flag = '23';
                            }
                            elseif ($discountCosmeticFood == 15) {
                                $orderLine->offer_flag = '24';
                            }
                            elseif ($discountCosmeticFood == 20) {
                                $orderLine->offer_flag = '25';
                            }
                            elseif ($discountCosmeticFood == 25) {
                                $orderLine->offer_flag = '26';
                            }
                            else {
                                $orderLine->offer_flag = '0';
                            }
                        }
                        elseif ($orderLine->flag == 7 || $orderLine->flag == 23) {
                            if ($discountNotCosmetic == 10) {
                                $orderLine->offer_flag = '23';
                            }
                            elseif ($discountNotCosmetic == 15) {
                                $orderLine->offer_flag = '24';
                            }
                            elseif ($discountNotCosmetic == 20) {
                                $orderLine->offer_flag = '25';
                            }
                            elseif ($discountNotCosmetic == 25) {
                                $orderLine->offer_flag = '26';
                            }
                            elseif ($discountNotCosmetic == 30) {
                                $orderLine->offer_flag = '27';
                            }
                            else {
                                $orderLine->offer_flag = '0';
                            }
                        }

                    }
                }
                else {
                    $orderLine->offer_flag = '0';
                }

                $newValue[] = $orderLine;

            }
//            dd($newValue);
            try {
                Log::info("send order to oracle");
                $client   = new \GuzzleHttp\Client();
                $response = $client->request('POST', 'https://sales.atr-eg.com/api/save_order_nettinghub4u.php', [
                    'form_params' => [
                        'order_lines' => $newValue
                    ], 'verify'   => false]);

                Log::info($response->getBody()->getContents());
                if ($response->getStatusCode() == 200) {
                    $updateOrder = OrderHeader::where('id', $order_id)->first();
                    if ($updateOrder) {
                        $updateOrder->send_t_o = '1';
                        $updateOrder->save();
                    }
                }

//                Log::critical('respons is ::' . $response->getBody()->getContents());
            }
            catch (\Exception $e) {
                Log::error('sending ORDER to oracle ORDER_ID=' . $order_id . ' ERROR::' . $e->getMessage());
                $code = $e->getCode();
                if ($code == 503) {
                    $userRow        = $this->UserRepository->find($user_id, ['account_id', 'full_name', 'phone', 'nationality_id', 'address']);
                    $client         = new \GuzzleHttp\Client();
                    $data           = [
                        'account_id'     => $userRow->account_id,
                        'full_name'      => $userRow->full_name,
                        'mobile'         => $userRow->phone,
                        'nationality_id' => $userRow->nationality_id,
                        'address'        => $this->faTOen($userRow->address) ?? "9 El sharekat, Opera",
                    ];
                    $this->response = $client->request('POST', 'https://sales.atr-eg.com/api/save_user_nettinghub_4u.php', ['form_params' => $data, 'verify' => false])->getBody()->getContents();
                    Log::info($this->response);
                }
//                Log::critical('sending ORDER to oracle ORDER_ID=' . $order_id . ' ERROR::' . $e->getMessage());
            }
        }
        else
            Log::info('successfully added out of oracle');
    }
    public function sendOrderToOracleMallOfArabia($order_id)
    {
        $OrderLines  = $this->OrderRepository->getOrder($order_id);
        $newValue    = [];
        $paymentCode = [];
        $max         = 0;

        if (count($OrderLines) > 0) {
            foreach ($OrderLines as $orderLine) {
                if (!array_key_exists($orderLine->payment_code, $paymentCode)) {
                    $max                                       += 1;
                    $OrderTypesArray[$orderLine->payment_code] = $max;
                }
                else {
                    $orderLine->has_free_product = 0;
                }
                $newValue[] = $orderLine;
            }
//            dd($newValue);
            try {
//                Log::info("send order to oracle mall of arabia");
                $client   = new \GuzzleHttp\Client();
                $response = $client->request('POST', 'https://sales.atr-eg.com/api/save_order_mall_of_arabia_test.php', [
                    'form_params' => [
                        'order_lines' => $newValue
                    ], 'verify'   => false]);

//                Log::info($response->getBody()->getContents());
                if ($response->getStatusCode() == 200) {
                    $updateOrder = OrderHeader::where('id', $order_id)->first();
                    if ($updateOrder) {
                        $updateOrder->send_t_o = '1';
                        $updateOrder->save();
                    }
                }
//                Log::critical('respons is ::' . $response->getBody()->getContents());
            }
            catch (\Exception $e) {
//                Log::error('sending ORDER to oracle ORDER_ID=' . $order_id . ' ERROR::' . $e->getMessage());
//                Log::critical('sending ORDER to oracle ORDER_ID=' . $order_id . ' ERROR::' . $e->getMessage());
            }
        }
        else
            Log::info('successfully added out of oracle');
    }

    public function sendOrderToOracleThatNotSending()
    {
        $ordersNotSend = OrderHeader::where(function ($query) {
            $query->where('payment_status', 'PAID')->where('wallet_status', 'only_fawry');
        })->where('user_id', '!=', '1')->where('send_t_o', '0')->where('created_at', '>', Carbon::now()->subDays(2))->pluck('id')->toArray();
        foreach ($ordersNotSend as $orderId) {
            $this->sendOrderToOracle($orderId);
        }
    }

    public function sendOrderToOracleNotSending($orderId)
    {
        $this->sendOrderToOracle($orderId);
    }

    public function faTOen($string)
    {
        return strtr($string, array('۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9', '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4', '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9'));
    }
}
