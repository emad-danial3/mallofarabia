<?php
namespace App\Libraries;

class ApiResponse{
	public static function errors($errorsArray,$code,$message='Invalid data'){
		return response(['status' => $code == 451 ? 401:-1,'message'=>$message,'errors' => $errorsArray],$code == 451 ? 401:$code);
	}

	public static function data($data,$message,$code){

		return response(['message'=>$message,'data' => $data,'status' => 1],$code);
	}

	public static function success($message,$code)
    {
        return response(['status' => 1, 'message' => $message],$code);
    }

    public static function bannedMessage()
    {
        return response(['status' => false, 'account_status' => 'banned', 'errors' => ['token' => [trans('main.account_is_banned')]]]);
    }
    public static function emptyToken()
    {
        return response(['status' => false, 'errors' => ['unauthorized'=>['you are unauthorized']]],401);
    }

    public static function emptyTokenHeader()
    {
        return response(['unauthorized'=>['you are unauthorized']],400);
    }

}
