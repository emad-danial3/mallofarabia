<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            "full_name"            => "required",
            "flag"                 => "required",
            "name_ar"              => "required",
            "name_en"              => "required",
            "price"                => "required",
            "tax"                  => "required",
            "discount_rate"        => "required",
            "price_after_discount" => "required",
            "quantity"             => "required",
            "weight"               => "required",
            "description_ar"       => "required",
            "description_en"       => "required",
            "category_id"          => "required",
            "oracle_short_code"    => "required|unique:products,oracle_short_code",
            "image"                => "required|image|mimes:jpeg,png,jpg",
            "options"              => "nullable|array",
            "optionValues"         => "nullable|array",
            "optionQuantity"       => "nullable|array",
            "optionPrice"          => "nullable|array",
            "filter_id"            => "nullable",
            "old_price"            => "nullable",
            "old_discount"            => "nullable",
            "barcode"            => "nullable",
            "visible_status"            => "nullable",
        ];
    }
}
