<?php

namespace App\Http\Requests\User;

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
            "email"=> 'required|string|email:rfc,dns|max:100|unique:users',
            "account_type"=> 'required|numeric|exists:account_types,id',
            "gender"=> "required",
            "address"=> "required",
            "city"=> "required",
            "area"=> "required",
            "building_number"=> "required|numeric",
            "floor_number"=> "required|numeric",
            "apartment_number"=> "required|numeric",
            "landmark"=> "required",
            "phone"=> "required|unique:users,phone|max:11|min:11|regex:/(01)[0-9]{9}/",
            "telphone"=> "nullable",
            "full_name"=> "required",
            "parent_id"=>"required",
            "stage"=>"required",
            "birthday"=> "required",
            "nationality"=> "egypt",
            "nationality_id"=> "required|numeric|unique:users,nationality_id",
            "front_id_image"=> "required|mimes:jpeg,jpg,png|required|max:2000",
            "back_id_image"=> "required|mimes:jpeg,jpg,png|required|max:2000",
            'password' => 'required|confirmed|min:6'

        ];
    }
}
