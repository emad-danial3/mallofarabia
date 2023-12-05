<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VoucherRequest extends FormRequest
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
            "code"=>'required',
            "name"=>'required',
            "description"=>'required',
            "starts_at"=>'required',
            'expires_at'=>'required|after:starts_at',
            'is_available'=>'required|in:0,1',
            'max_uses'=>'required|numeric',
            'max_uses_user'=>'required|numeric',
            'discount_amount'=>'required|numeric',
            'discount_type'=>'required',
            'voucher_type_id'=>'required',
            'image'=>'required|image|max:2048|mimes:jpeg,png,jpg'
        ];
    }
}
