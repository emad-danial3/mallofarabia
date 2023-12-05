<?php

namespace App\Http\Services\PaidOrderActions;


use App\Http\Repositories\OrderRepository;
use App\Http\Repositories\IUserRepository;

use App\Http\Services\NotificationsService;
use App\Libraries\Notification;
use App\Mail\singleCommissionEmail;
use App\Models\OrderHeader;
use App\SendMessage\SendMessage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SingleOrderPaidActions extends MainPaidActions
{
    private $UserRepository;
    private $OrderRepository;

    public function __construct( IUserRepository $UserRepository,
                                OrderRepository      $OrderRepository, Notification $Notification, NotificationsService $NotificationService)
    {
        parent::__construct( $UserRepository, $Notification, $NotificationService);
        $this->UserRepository  = $UserRepository;
        $this->OrderRepository = $OrderRepository;
    }

    public function sendCommissionEmail($user_id)
    {
        $userRow   = $this->UserRepository->find($user_id, ['email', 'full_name']);
        $emailData = [
            "subject"   => "Congratulation Mail",
            "full_name" => $userRow->full_name,
        ];
        // send Email
        Mail::to($userRow->email)->send(new singleCommissionEmail($emailData));
    }

    public function sendCommissionMessage($user_id)
    {
        $userRow = $this->UserRepository->find($user_id, ['id', 'email', 'full_name', 'phone', 'device_id']);
//        Log::info('user12',['user'=>$userRow]);

        if (!empty($userRow)) {
            $messageText = 'Congratulation ' . $userRow['full_name'] . ' Check your commission';

            $x = $this->Notification->send($userRow->device_id, 'NettingHub', $messageText);
//            Log::info('user13',['notification'=>$x]);

            $kh = $this->NotificationService->create(['user_id' => $userRow['id'], 'title' => 'NettingHub', 'body' => $messageText]);
//            Log::info('user14',['notification'=>$kh]);

            $messageText = str_replace(' ', '%20', $messageText);
            // send Message
            SendMessage::sendMessage($userRow->phone, $messageText);

        }
    }

    public function sendOrderToOracle($order_id)
    {
        $OrderLines  = $this->OrderRepository->getOrder($order_id);
        $user_id     = OrderHeader::where('id', $order_id)->first()['user_id'];
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

            try {
                // start
//                $client = new \GuzzleHttp\Client();
//                $response = $client->request('POST', 'https://sales.atr-eg.com/api/save_order_nettinghub4u.php', [
//                    'form_params' => [
//                        'order_lines' => $newValue
//                    ], 'verify' => false]);
////                Log::info($response->getBody()->getContents());
//                if($response->getStatusCode() == 200){
//                    $updateOrder= OrderHeader::where('id',$order_id)->first();
//                    if($updateOrder){
//                        $updateOrder->send_t_o='1';
//                        $updateOrder->save();
//                    }
//                }
                // end
//            Log::critical('respons is ::'.$response->getBody()->getContents());

            }
            catch (\Exception $e) {
//                Log::error('sending ORDER to oracle ORDER_ID=' . $order_id . ' ERROR::' . $e->getMessage());
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
//                    Log::info($this->response);
                }
//            Log::critical('sending ORDER to oracle ORDER_ID='.$order_id.' ERROR::'.$e->getMessage());
            }
        }
        else
            Log::info('successfully added out of oracle');
    }

    public function faTOen($string)
    {
        return strtr($string, array('۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9', '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4', '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9'));
    }

}
