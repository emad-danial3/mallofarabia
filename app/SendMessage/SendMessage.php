<?php

namespace App\SendMessage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;

class SendMessage
{
    public static function sendMessage($phone,$text)
    {

        sleep(3);
        date_default_timezone_set("Africa/Cairo");
        $date = date('YmdHis');
        $url = "https://www.ezagel.com/portex_ws/service.asmx/Send_SMSWithoutMsg_ID?Mobile_NO=%2B2$phone&Body=$text&Validty=&StartTime=&Sender=Netting%20Hub&User=Eva%20Cosmetics&Password=Eva@1234&Service=Market&SMSTag=";
        ini_set('allow_url_fopen',1);
        $c= curl_init($url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        $page= curl_exec($c);
        curl_close($c);


//        $contents = file_get_contents($url);

        return  simplexml_load_string($page);
    }
}
