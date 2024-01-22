<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            "name_ar"              => "required",
            "name_en"              => "required",
            "price"                => "required",
            "tax"                  => "required",

            "price_after_discount" => "required",

            "weight"               => "required",
            "description_ar"       => "required",
            "description_en"       => "required",
            "oracle_short_code"    => "required",
            "image"                => "image|mimes:jpeg,png,jpg",
            "stock_status"=>"required",
            "barcode"            => "required|unique:products,barcode," . request()->product,
            "filter_id"            => "nullable",
            "visible_status"            => "nullable",
        ];
    }
}
