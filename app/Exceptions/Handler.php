<?php

namespace App\Exceptions;

use App\Libraries\ApiResponse;
use App\SendMessage\SendMessage;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

   /* public function render($request, Throwable $e)
    {
//        $slackInputData =json_encode(['error'=>$e->getMessage(),'request_inputs'=>$request->all()]);
//        \Slack::send($slackInputData);
        //SendMessage::sendMessage('01126414838','Exception From Laravel');
   //     return ApiResponse::errors($e->getMessage(),500);
    }*/
}
