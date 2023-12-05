<?php

namespace App\ValidationClasses;

class OrderValidation
{
    public static function createOrder():array
    {

        return[
            'created_for_user_id'=>'required|exists:users,id',
            'order_type'=>'required|in:single,create_user,free_account',
            'address_is_changed'=>'required|in:0,1',
        ];
    }

    public static function validateAddress():array
    {
        return[
            'address'=>'required',
            'city'=>'required',
            'area'=>'required',
            'building_number'=>'required',
            'floor_number'=>'required',
            'apartment_number'=>'required',
            'landmark'=>'required',
        ];
    }

    public static function fawryOrder():array
    {
        return[
            'requestId' => 'required',
            'fawryRefNumber' => 'required',
            'orderStatus' => 'required',
        ];
    }


    public static function myOrder():array
    {
        return[
            'start_date' => 'sometimes|date_format:Y-m-d',
            'end_date'   => 'sometimes|date_format:Y-m-d|after_or_equal:start_date',

        ];
    }

    public static function updatePaymentCodeRules():array
    {
        return[
            'id'           => 'required|exists:order_headers,id',
            'payment_code' => 'required',
        ];
    }

    public static function orderDetailRules():array
    {
        return[
            'id'  => 'required|exists:order_headers,id',
        ];
    }

    public function reorderRules():array
    {
        return[
            'items'=>'required|array|min:1',
            'items.*.id'=>'required|exists:products,id',
            'items.*.quantity'=>'required|integer|gt:0',
        ];
    }

}
