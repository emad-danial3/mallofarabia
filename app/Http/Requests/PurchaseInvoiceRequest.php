<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            "flag"                 => "required",
            "price"                => "required",
            "tax"                  => "required",
            "discount_rate"        => "required",
            "price_after_discount" => "required",
            "quantity"             => "required",
            "item_code"            => "required",
            "oracle_short_code"    => "required",
            "store_id"             => "nullable",
            "admin_id"             => "nullable",
            "weight"               => "nullable",
            "id"                   => "nullable",

        ];
    }
}
