<?php

namespace App\Libraries;

use Illuminate\Support\Facades\Validator;

class ApiValidator
{
    public static function validateWithNoToken($rules)
    {
        $validate = Validator::make(request()->all(), $rules);
        if ($validate->fails()) {
            return $validate->messages();
        }
    }
}
