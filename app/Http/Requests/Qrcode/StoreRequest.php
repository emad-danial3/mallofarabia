<?php

namespace App\Http\Requests\Qrcode;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            "account_type"=>'required|exists:account_types,id',
            "start_date"=>'required',
            'end_date'    =>  'required|after:start_date',
            'is_available'=>'required|in:0,1'

        ];
    }
}
