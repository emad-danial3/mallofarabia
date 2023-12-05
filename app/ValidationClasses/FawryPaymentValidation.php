<?php

namespace App\ValidationClasses;

class FawryPaymentValidation
{
    public static function payOrder():array
    {

        return[
            'fawryRefNumber' => 'required',
            'orderStatus' => 'required|in:PAID,EXPIRED',
            'paymentMethod' => 'nullable',
            'orderItems' => 'required',
        ];
    }
}
