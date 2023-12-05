<?php

namespace App\Http\Services\PaidOrderActions;


use App\Http\Repositories\IUserRepository;
use App\Http\Services\NotificationsService;
use App\Libraries\Notification;
use App\Mail\RegistrationEmail;
use App\SendMessage\SendMessage;
use Illuminate\Support\Facades\Mail;

class CreateUserPaidPaidActions extends MainPaidActions
{
    private $UserRepository;

    public function __construct( IUserRepository $UserRepository,
    Notification $Notification,NotificationsService $NotificationService

    )
    {
        parent::__construct($UserRepository,$Notification,$NotificationService);
        $this->UserRepository = $UserRepository;

    }

    public function sendCommissionEmail($user_id)
    {
       $userRow = $this->UserRepository->find($user_id, ['email', 'initial_password', 'full_name']);
       $emailData = [
         "subject"   => "Congratulation Mail",
         "email"     => $userRow->email,
         "password"  => $userRow->initial_password,
         "full_name" => $userRow->full_name,
       ];
        // send Email
         Mail::to($userRow->email)->send(new RegistrationEmail($emailData));
    }

    public function sendCommissionMessage($user_id)
    {
        $userRow = $this->UserRepository->find($user_id, ['id','email', 'initial_password', 'full_name', 'phone','device_id']);
        if (!empty($userRow))
        {
            $messageText    = 'Hello '.$userRow->full_name.'Your Order is on Progress Now !';
            $this->Notification->send($userRow->device_id,'NettingHub',$messageText);
            $this->NotificationService->create(['user_id'=>$userRow['id'],'title'=>'NettingHub','body'=>$messageText]);
//            $messageText    = str_replace(' ', '%20', $messageText);
//            // send Message
//             SendMessage::sendMessage($userRow->phone, $messageText);

        }
    }
    public function sendCommissionNotification($user_id){
        $userRow = $this->UserRepository->find($user_id, ['device_id']);
        if (!empty($userRow))
        {
            $messageText    = 'Hello '.$userRow->full_name.', \n User Name:'.$userRow->email.' \n Password:\n  '.$userRow->initial_password.' \n Download the Application from Google play or APP store';
            if(!empty($userRow->device_id))
                $this->Notification->send($userRow->device_id,'NettingHub',$messageText);

        }

    }
}
