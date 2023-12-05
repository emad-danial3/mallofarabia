<?php

namespace App\Http\Services\PaidOrderActions;


use App\Http\Repositories\IUserRepository;
use App\Http\Services\BaseServiceController;
use App\Http\Services\NotificationsService;
use App\Libraries\Notification;
use App\Mail\CommissionEmail;
use App\Models\OrderHeader;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\SendMessage\SendMessage;


abstract class MainPaidActions extends BaseServiceController
{

    private $UserRepository;

    protected $Notification;
    protected $NotificationService;

    public function __construct(
                                IUserRepository       $UserRepository,

                                Notification $Notification,NotificationsService $NotificationService)
    {

      $this->UserRepository = $UserRepository;

      $this->Notification = $Notification;
      $this->NotificationService = $NotificationService;
    }

    public function updateCommissions($conditions , $data)
    {
        return $this->CommissionRepository->updateCommission($conditions, $data);
    }

    public function updateUserStage($user_id,$data)
    {
       $this->UserRepository->updateUser($user_id,$data);
    }

    public function addMemberToMyWallet($user_id, $walletEvaluation)
    {
        // add  to my row if exist or create one
        $my_wallet_row = $this->UserWalletRepository->getCurrentWallet($user_id);

        if (!empty($my_wallet_row))
        {
            $newTotalCount = $my_wallet_row->total_members_count + 1;

            if(($newTotalCount % $walletEvaluation->value == 0) && ( $newTotalCount / $walletEvaluation->value ) > $my_wallet_row->withdrawal_member_count)
            {
                $this->UserWalletRepository->updateWallet(['user_id' => $user_id],[
                    'total_members_count'     => $newTotalCount,
                    'withdrawal_member_count' => ($my_wallet_row->withdrowal_member_count +1),
                    'total_wallet'            => $my_wallet_row->total_wallet   + $walletEvaluation->amount,
                    'current_wallet'          => $my_wallet_row->current_wallet + $walletEvaluation->amount,
                ]);
            }
            else
            {
                // increment the total members by 1 only
                $this->UserWalletRepository->updateWallet(['user_id' => $user_id], ['total_members_count' => $newTotalCount ]);
            }
        }
        else
        {
            $this->UserWalletRepository->create([
                'user_id'                 => $user_id,
                'total_orders_amount'     => 0,
                'total_members_count'     => 0,
                'withdrawal_order_count'  => 0,
                'withdrawal_member_count' => 0,
                'total_wallet'            => 0,
                'current_wallet'          => 0,
            ]);
        }

    }

    public function addMemberToMyParentWallet($child_id, $walletsEvaluationForMember)
    {
        $my_parents = $this->UserRepository->getAccountParent($child_id);

        foreach ($my_parents as  $parent)
        {
            $this->addMemberToMyWallet($parent->parent_id, $walletsEvaluationForMember);
        }

    }

    public function addOrderToMyWallet($user_id,$walletEvaluation,$totalOrder,$relationType = null,$orderId=null)
    {
        $parentRow = $this->UserWalletRepository->getCurrentWallet($user_id);
        if (!empty($parentRow)) {

            $newTotalOrderCount = $parentRow->total_orders_amount + $totalOrder;
            if( ($newTotalOrderCount / $walletEvaluation->value) > $parentRow->withdrawal_order_count &&
                ( ($newTotalOrderCount / $walletEvaluation->value) - $parentRow->withdrawal_order_count) >= 1
            )
            {
                if(($relationType && $relationType=='parent' &&$orderId)){
                    $sumWalletThisManth=$this->UserWalletRepository->getHistoryWalletAsParent($user_id);
                    if($sumWalletThisManth < 300 ){
                        $countForNumber = floor(( ($newTotalOrderCount / $walletEvaluation->value) - $parentRow->withdrawal_order_count ));
                        $newInWallet=($sumWalletThisManth + ($walletEvaluation->amount * $countForNumber)) < 300 ? ($sumWalletThisManth + ($walletEvaluation->amount * $countForNumber)): 300;
                        $addToWallet=($newInWallet-$sumWalletThisManth);
                        $addToTotal=(($addToWallet/$walletEvaluation->amount)*$walletEvaluation->value);
                        $this->UserWalletRepository->updateWallet(['user_id' => $user_id], [
                            'total_orders_amount'    => ($parentRow->total_orders_amount + $addToTotal),
                            'withdrawal_order_count' => $parentRow->withdrawal_order_count+(float)($addToWallet/$walletEvaluation->amount),
                            'total_wallet'           => ($parentRow->total_wallet  + ($addToWallet)),
                            'current_wallet'         => ($parentRow->current_wallet + ($addToWallet)),
                        ]);

                    }
                }else{
                    $countForNumber = floor(( ($newTotalOrderCount / $walletEvaluation->value) - $parentRow->withdrawal_order_count ));
                    $this->UserWalletRepository->updateWallet(['user_id' => $user_id], [
                        'total_orders_amount'    => $newTotalOrderCount,
                        'withdrawal_order_count' => $parentRow->withdrawal_order_count+$countForNumber,
                        'total_wallet'           => ($parentRow->total_wallet  + ($walletEvaluation->amount * $countForNumber)),
                        'current_wallet'         => $parentRow->current_wallet + ($walletEvaluation->amount * $countForNumber),
                    ]);
                }
            }
            else
            {
                // increment the total members by 1 only
                if(($relationType && $relationType=='parent' &&$orderId)){
                    $sumWalletThisManth=$this->UserWalletRepository->getHistoryWalletAsParent($user_id);
                    if($sumWalletThisManth < 300 ){
                        $this->UserWalletRepository->updateWallet(['user_id' => $user_id], ['total_orders_amount' => $newTotalOrderCount]);
                    }
                }else{
                    $this->UserWalletRepository->updateWallet(['user_id' => $user_id], ['total_orders_amount' => $newTotalOrderCount]);
                }
            }
        }
        else {
            // insert new row for this user

            $this->UserWalletRepository->create([
                'user_id'                 => $user_id,
                'total_orders_amount'     => $totalOrder,
                'total_members_count'     => 0,
                'withdrawal_order_count'  => 0,
                'withdrawal_member_count' => 0,
                'total_wallet'            => 0,
                'current_wallet'          => 0,
            ]);

        }
    }

    public function addOrderToMyParentWallet($child_id, $walletsEvaluationForOrder,$total_order,$orderId =null)
    {
        $my_parents = $this->UserRepository->getAccountParent($child_id);
        foreach ($my_parents as  $parent)
        {
            $this->addOrderToMyWallet($parent->parent_id, $walletsEvaluationForOrder, $total_order,'parent',$orderId);
        }
    }

    public function sendCommissionEmailToParent($child_id)
    {
        $child_Data = $this->UserRepository->getAccountTypeAndName($child_id);
        $my_parents = $this->UserRepository->getAccountParent($child_id);
        foreach ($my_parents as $parent)
        {
            $emailData['subject']          = "Commission mail";
            $emailData['parent_full_name'] = ucwords($parent->full_name);
            $emailData['child_full_name']  = ucwords($child_Data['child_full_name']);
            $emailData['child_type']       = ucwords($child_Data['child_type']);
            // send Email
             Mail::to($parent->email)->send(new CommissionEmail($emailData));
        }
    }

    public function sendCommissionMessageToParent($child_id)
    {
        $child_Data = $this->UserRepository->getAccountTypeAndName($child_id);
        $my_parents = $this->UserRepository->getAccountParent($child_id);
        foreach ($my_parents as $parent)
        {
            $messageText='Congratulation '.ucwords($parent->full_name).' , '. ucwords($child_Data['child_full_name']).' now joining as a '.$child_Data['child_type'].' member on your Team! Check your commission';
           $this->Notification->send($parent->device_id,'NettingHub',$messageText);
//            Log::info('notifi'.$notifi,[$parent->device_id]);
            if (isset($parent->id))
                $this->NotificationService->create(['user_id'=>$parent->id,'title'=>'NettingHub','body'=>$messageText]);

            $messageText=str_replace(' ', '%20', $messageText);
            // send Message
             SendMessage::sendMessage($parent->phone, $messageText);
//            Log::info('notifi'.$notifi,$cr);

            //sendNotification

        }
    }


    public function sendUserToOracle($user_id)
    {
        $userRow = $this->UserRepository->find($user_id,['account_id','full_name','phone','nationality_id','address']);
        // send User To Guzzle
        try {
            $client = new \GuzzleHttp\Client();
            $data=[
                'account_id'      => $userRow->account_id,
                'full_name'       =>  $userRow->full_name,
                'mobile'          =>  $userRow->phone,
                'nationality_id'  =>  $userRow->nationality_id,
                'address'         =>  $this->faTOen($userRow->address)??"9 El sharekat, Opera",
            ];
            $response = $client->request('POST','https://sales.atr-eg.com/api/save_user_nettinghub_4u.php',['form_params'=>$data ,'verify' => false]);
            Log::info($response->getBody()->getContents());

        }catch (\Exception $e){
            Log::error('sending USER to oracle USER_ID :: '.$userRow->id.' ERROR:: '.$e->getMessage());
        }
    }
    abstract  public function sendCommissionEmail($user_id);

    abstract  public function sendCommissionMessage($user_id);

public function faTOen($string)
    {
        return strtr($string, array('۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9', '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4', '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9'));
    }
}
