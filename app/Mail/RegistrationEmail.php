<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Config;

class RegistrationEmail extends Mailable
{
    use Queueable, SerializesModels;
    private $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data=$data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
//         if(str_contains($this->data['email'],'@atr-eg.com')){
//             $config = array(
//                 'mail.host'       => 'smtp.eva-cosmetics.com',
//                 'mail.port'       => 465,
//                 'mail.from'       => array('address' => 'atr.portal@eva-cosmetics.com'),
//                 'mail.username'   => 'atr.portal@eva-cosmetics.com',
//                 'mail.password'   => 'Clackeevtyd1',
//             );
//             Config::set('mail', $config);
// //               Config::set( 'mail.port', 465);
// //              Config::set(  'mail.from', array('address' => 'atr.portal@eva-cosmetics.com'));
// //               Config::set( 'mail.username','atr.portal@eva-cosmetics.com');
// //               Config::set( 'mail.password','Clackeevtyd1');
//         }

        return $this->cc(['support@4unettinghub.com'])->subject($this->data["subject"])->markdown('emails.RegisterUserData')->with("data",$this->data);
    }
}
