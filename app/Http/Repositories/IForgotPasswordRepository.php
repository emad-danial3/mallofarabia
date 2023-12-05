<?php

namespace App\Http\Repositories;

use App\Models\ForgotPassword;

class IForgotPasswordRepository extends BaseRepository implements ForgotPasswordRepository
{
    public function __construct(ForgotPassword $model){
        parent::__construct($model);
    }

    public function createRestPassword($data)
    {
        ForgotPassword::where('user_id',$data['user_id'])->delete();
      return ForgotPassword::create($data);
    }
    public function checkValidateCode($data)
    {
      return ForgotPassword::where('user_id',$data['user_id'])->where('code',$data['code'])->where('expiry_date','>',$data['now'])->first();
    }
}
