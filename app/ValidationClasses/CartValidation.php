<?php

namespace App\ValidationClasses;

class CartValidation
{
    public static function cartProducts():array
    {

        return[
            'created_for_user_id'=>'required|exists:users,id',
            'order_type' => 'required|in:single,create_user,free_account',
            'items'=>'required|array|min:1',
            'items.*.id'=>'required|exists:products,id',
            'items.*.quantity'=>'required|integer|gt:0',
        ];
    }
}
