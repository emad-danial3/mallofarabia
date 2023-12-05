<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VoucherUpdateRequest extends FormRequest
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
            "code"=>'nullable',
            "name"=>'nullable',
            "description"=>'nullable',
            "starts_at"=>'nullable',
            'expires_at'=>'nullable|after:starts_at',
            'is_available'=>'nullable|in:0,1',
            'max_uses'=>'nullable|numeric',
            'max_uses_user'=>'nullable|numeric',
            'discount_amount'=>'nullable|numeric',
            'discount_type'=>'nullable',
            'voucher_type_id'=>'nullable',
            'image'=>'nullable|image|max:2048|mimes:jpeg,png,jpg'
        ];
    }
}
