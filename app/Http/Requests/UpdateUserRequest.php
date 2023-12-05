<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'email'          => 'required|email:rfc,dns|unique:users,email,' . request()->user,
            'full_name'      => 'required',
            "phone"=> 'required|regex:/(01)[0-9]{9}/|max:11|min:11|unique:users,phone,' . request()->user,
            'front_id_image' => 'image|mimes:jpeg,png,jpg',
            'back_id_image'  => 'image|mimes:jpeg,png,jpg',
            'password' => 'nullable'
        ];
    }
}
