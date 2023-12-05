<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\NotificationRequest;
use App\Http\Services\NotificationsService;
use App\Http\Services\UserService;
use App\Libraries\Notification;
use App\Mail\NotificationEmail;
use App\SendMessage\SendMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\HtmlString;

class NotificationsController extends HomeController
{

    private  $UserService;
    private  $Notification;
    private  $NotificationsService;

    public function __construct(UserService  $UserService, Notification  $Notification, NotificationsService $NotificationsService)
    {
        $this->UserService          = $UserService;
        $this->Notification         = $Notification;
        $this->NotificationsService = $NotificationsService;
    }

    public function index()
    {
        $data = $this->UserService->getAllUsersWithOutPagination();
        return view('AdminPanel.PagesContent.Notifications.index')->with('users',$data);
    }

//     public function store(NotificationRequest $request)
//     {
//         $validated = $request->all();
//         $title     = $validated['title'];
//         $body      = $validated['body'];
//         $mediaType = $validated['mediaType'];
//         $usersId    = $validated['usersId'];
//         foreach ($usersId as  $userId)
//         {
//             $userRow = $this->UserService->getUser($userId);
//             if (in_array(1,$mediaType))
//             {

//                 //SEND Notification
//                 $title = str_replace("&nbsp;", "", $title);
//                 $title = html_entity_decode($title);

//                 $body = str_replace("&nbsp;", "", $body);
//                 $body = html_entity_decode($body);

//                 $this->Notification->send($userRow->device_id,strip_tags($title),strip_tags($body));
//                 $this->NotificationsService->create([
//                     "user_id" => $userRow->id,
//                     "title" => $title,
//                     "body" => $body
//                 ]);
//             }
//             if (in_array(2,$mediaType))
//             {
//                 //SEND SMS
//                  SendMessage::sendMessage($userRow->phone,$body);
//             }
//             if (in_array(3,$mediaType))
//             {

//                 //SEND Email
//                 $emailData['subject'] = "NettingHub";
//                 $emailData['title']   = $title;
//                 $emailData['body']    = $body;
//                 Log::info('mail start');

//                 try {
//                     Mail::to($userRow->email)->send(new NotificationEmail($emailData));
//                     Log::info('mail start'.$userRow->email);

//                 }catch (\Exception $e) {
//                     Log::info('mail start'.$e->getMessage());

//                 }
// //                    if (count(Mail::failures()) > 0){
// //                        Log::info('mail issue');
// //                    }

//             }
//         }
//         return redirect()->back()->with('message' , "Send Successfully");
//     }




    public function store(NotificationRequest $request)
    {
        
        $validated = $request->all();
        $title     = $validated['title'];
        $body      = $validated['body'];
        $mediaType = $validated['mediaType'];
        $usersId    = $validated['usersId'];

        $allUsersData = $this->UserService->findCustomDataIds($usersId,['id','email','phone','device_id']);
     
        $allUsersEmails= array_column($allUsersData, 'email');
        $allUsersPhones= array_column($allUsersData, 'phone');
        $allUsersDevice_ids= array_column($allUsersData, 'device_id');


        if (in_array(1,$mediaType))
        {
            //SEND Notification
            $title = str_replace("&nbsp;", "", $title);
            $title = html_entity_decode($title);

            $body = str_replace("&nbsp;", "", $body);
            $body = html_entity_decode($body);

            $this->Notification->send($allUsersDevice_ids,strip_tags($title),strip_tags($body));
            foreach ($allUsersData as  $oneUserRow)
            {
              // Save Notification in database
                $this->NotificationsService->create([
                    "user_id" => $oneUserRow['id'],
                    "title" => $title,
                    "body" => $body
                ]);
            }
        }

        if (in_array(2,$mediaType) &&count($allUsersPhones) >0)
        {
            foreach ($allUsersPhones as  $phone)
            {
                //SEND SMS
                SendMessage::sendMessage($phone,$body);
            }
        }

        if (in_array(3,$mediaType) && count($allUsersEmails) >0)
        {
           
           
            
               //SEND Email
            $emailData['subject'] = "NettingHub";
            $emailData['title']   = $title;
            $emailData['body']    = $body;
            Log::info('mail start');
                if(count($allUsersEmails) > 498){
                 $roundNum=floor(count($allUsersEmails) / 498);
                 $start=0;
                 $end=1000000;
                 for($ii = 0;$ii < $roundNum;$ii++)
                 {
                     try {
                     $start=$ii*498;
                     $end=$start+498;
                     $newusersemails=array_slice($allUsersEmails, $start, $end);
                          Mail::to('info@nettinghub.com')->bcc($newusersemails)->send(new NotificationEmail($emailData));
                          Log::info('mail send success  num round '.$ii.'');
                     }catch (\Exception $e) {
                         Log::info('mail error Exception '.$e->getMessage());
                     }
                 }
             }else{
                 try {
                     Mail::to('info@nettinghub.com')->bcc($allUsersEmails)->send(new NotificationEmail($emailData));
                     Log::info('mail send success   ');
                 }catch (\Exception $e) {
                     Log::info('mail error Exception '.$e->getMessage());
                 }
             }
            
            //SEND Email
            // $emailData['subject'] = "NettingHub";
            // $emailData['title']   = $title;
            // $emailData['body']    = $body;
            // Log::info('mail start');
            
            // try {
            //     $send= Mail::to('info@nettinghub.com')->bcc($allUsersEmails)->send(new NotificationEmail($emailData));
            //      Log::info('mail send success '.$send);
            //  }catch (\Exception $e) {
            //      Log::info('mail error Exception '.$e->getMessage());
            //  }
        }

        return redirect()->back()->with('message' , "Send Successfully");
    }


    private function test($body)
    {

    }
}
