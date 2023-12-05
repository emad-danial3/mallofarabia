<?php

namespace App\ValidationClasses;

class ProductsValidation
{

    public static function getAllProducts(): array
    {
        return[
            'created_for_user_id' => 'required|exists:users,id',
            'order_type' => 'required|in:single,create_user,free_account',
        ];
    }


}
