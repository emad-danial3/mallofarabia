<?php

namespace App\Libraries;

class Notification
{
//    private   $serverKey = "AAAA1tFc3CI:APA91bEr33T9H4Eqfc9YOGXWJaZdnH-GLNGWnd7Mcqck1dzrlRhz6ON1-9UBiH9dBTwcsY-eoiD8G5o18Bu0SmH8yi6REZddLJEPJWDZ3wp5WSIgfkjNhqn2wKLGBYVHaw0KPco0T2Fx";
    private   $serverKey = "AAAASVdHDmg:APA91bEBO_FrGxvS7ZkQQy-Kg8uwLRgjLiba0NmxOW5a9n-ZwseO57owKYNkxrNbxL2u1ulxmxE8ccWUXbNdz8xLkTKZ1xF1d0JVGUvPjMzP-Eynp_A8VFhc_jB-fMAhHbTFYSzBmCq_";

    public  function send($deviceToken,$title,$body)
    {
        $notification = [
            'title'        => $title,
            'body'         =>  $body,
            "icon"         => "icon.png",
            "click_action" => "null",
            "sound"        => "default",
            "badge"        =>1
        ];
        $data = [
            'priority'          => 'high',
            "sound"             => "default",
            'content_available' => true,
            ];



        if(is_array($deviceToken)){

            for($i = 0;$i<(count($deviceToken));$i++)
            {
               if(strlen($deviceToken[$i]) < 30){
                   $deviceToken[$i]='/topics/'.$deviceToken[$i].'';
               }
            }

            $fcmNotification = [
                'registration_ids' => $deviceToken,
                'notification' => $notification,
                'data'         => $data,
                'priority'     => 'high',
            ];

        }else{
            if(strlen($deviceToken) < 30)
            {
                $deviceToken='/topics/'.$deviceToken.'';
            }


            $fcmNotification = [
                'to'           => $deviceToken,
                'notification' => $notification,
                'data'         => $data,
                'priority'     => 'high',
            ];
        }

        // if(strlen($deviceToken) < 30)
        // {
        //     $deviceToken='/topics/'.$deviceToken.'';
        // }
        // $fcmNotification = [
        //     'to'           => $deviceToken,
        //     'notification' => $notification,
        //     'data'         => $data,
        //     'priority'     => 'high',
        // ];

        $headers = [
            'Authorization: key=' . $this->serverKey,
            'Content-Type: application/json'
        ];
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $cRequest = curl_init();
        curl_setopt($cRequest, CURLOPT_URL, $fcmUrl);
        curl_setopt($cRequest, CURLOPT_POST, true);
        curl_setopt($cRequest, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($cRequest, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cRequest, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($cRequest, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($cRequest);
        curl_close($cRequest);
        return $result;
    }

}
