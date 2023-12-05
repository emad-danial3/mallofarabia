<?php

namespace App\ValidationClasses;

class PayByWalletValidation
{
    public static function payByWalletOrder():array
    {
        return[
            'created_for_user_id'=>'required|exists:users,id',
            'order_type'=>'required|in:single,create_user,free_account',
            'address_is_changed'=>'required|in:0,1',
        ];
    }
}
