<?php

namespace App\ValidationClasses;

use Illuminate\Validation\Rule;

class UserValidation
{
    public static function loginRules(): array
    {
        return [
            'email'     => 'required|exists:users,email',
            'password'  => 'required|min:4',
            'language'  => 'required|in:ar,en',
            'version'   => 'required',
            'platform'  => 'required|in:Android,Ios',
            'device_id' => 'nullable',
        ];
    }

    public static function orderRules(): array
    {
        return [
            'address_id'     => 'required|exists:user_addresses,id',
            'wallet_status'  => [
                'required',
                Rule::in(['cash', 'only_fawry']),
            ],
            'items'          => [
                'required',
                'array',
            ],

        ];
    }

    public static function orderCheckRules(): array
    {
        return [

            'items'          => [
                'required',
                'array',
            ],

        ];
    }

    public static function addressRules(): array
    {
        return [
            'address'          => 'required',
            'landmark'         => 'required',
            'receiver_name'    => 'required',
            'receiver_phone'   => 'required|digits:11',
            'floor_number'     => 'required',
            'apartment_number' => 'required',
            'city_id'          => 'required',
            'country_id'       => 'required',
            'area_id'          => 'required',
        ];
    }

    public static function refreshTokenRules(): array
    {
        return [
            'token' => 'required',
        ];
    }

    public static function uploadProfileImage(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'image'   => 'required|image|mimes:jpeg,jpg,png',
        ];
    }

    public static function UserId(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
        ];
    }

    public static function changePassword(): array
    {
        return [
            'old_password' => 'required',
            'password'     => 'required',
        ];
    }

    public static function deviceId(): array
    {
        return [
            'id' => 'required',
        ];
    }

    public static function email(): array
    {
        return [
            'email' => 'required|email:rfc,dns',
        ];
    }

    public function restPasswordRules(): array
    {
        return [
            'emailorphone' => 'required',
            'language'     => 'required|in:ar,en',
        ];
    }

    public function setNewPasswordRules(): array
    {
        return [
            'emailorphone' => 'required',
            'language'     => 'required|in:ar,en',
            'new_password' => 'required|min:6',
        ];
    }

    public function checkCodeRules(): array
    {
        return [
            'emailorphone' => 'required',
            'language'     => 'required|in:ar,en',
            'code'         => 'required',
        ];
    }

    public function GetLinkRules(): array
    {
        return [
            'is_free_link' => 'required|in:1,0',
        ];
    }

    public function myCommissionPeriod(): array
    {
        return [
            'start_date' => 'sometimes|date_format:Y-m-d',
            'end_date'   => 'sometimes|date_format:Y-m-d|after_or_equal:start_date',
        ];
    }

    public function registerRules(): array
    {
        return [
            'email'                => 'required|string|email:rfc,dns|max:100|unique:users',
            'gender'               => 'required|in:male,female',
            'country_id'           => 'required|exists:countries,id',
            'city_id'              => 'required|exists:cities,id',
            'area_id'              => 'required|exists:areas,id',
            'address'              => 'required',
            'phone'                => 'required|max:11|min:11|unique:users|regex:/(01)[0-9]{9}/',
            'first_name'           => 'required|regex:/^[a-zA-ZÑñ\s]+$/',
            'middle_name'          => 'required|regex:/^[a-zA-ZÑñ\s]+$/',
            'last_name'            => 'required|regex:/^[a-zA-ZÑñ\s]+$/',
            'nationality_id'       => 'required|max:14|min:14|unique:users',
            'front_id_image'       => 'required|image',
            'back_id_image'        => 'required|image',
            'password'             => 'required|min:6',
            'parent_membership_id' => 'nullable|exists:user_memberships,id'
        ];
    }
    public function upgradeCustomerToMemberRules(): array
    {
        return [
            'country_id'           => 'required|exists:countries,id',
            'city_id'              => 'required|exists:cities,id',
            'area_id'              => 'required|exists:areas,id',
            'nationality_id'       => 'required|max:14|min:14|unique:users',
            'front_id_image'       => 'required|image',
            'back_id_image'        => 'required|image',
            'parent_membership_id' => 'nullable|exists:user_memberships,id'
        ];
    }

    public function sendContactUsRules(): array
    {
        return [
            'phone'      => 'required',
            'subject'    => 'required',
            'message'    => 'required',
        ];
    }

    public function registerCustomerRules(): array
    {
        return [
            'email'       => 'required|string|email:rfc,dns|max:100|unique:users',
            'gender'      => 'required|in:male,female',
            'address'     => 'required',
            'phone'       => 'required|max:11|min:11|unique:users|regex:/(01)[0-9]{9}/',
            'first_name'  => 'required|regex:/^[a-zA-ZÑñ\s]+$/',
            'middle_name' => 'required|regex:/^[a-zA-ZÑñ\s]+$/',
            'last_name'   => 'required|regex:/^[a-zA-ZÑñ\s]+$/',
            'password'    => 'required|min:6',
        ];
    }

    public function completeRegisterRules(): array
    {
        return [
            'address'          => 'required',
            'city'             => 'required',
            'area'             => 'required',
            'building_number'  => 'required',
            'floor_number'     => 'required',
            'apartment_number' => 'required',
            'landmark'         => 'required',
            'birthday'         => 'required',
            'nationality_id'   => 'required|max:14|min:14|unique:users',
            'front_id_image'   => 'required',
            'back_id_image'    => 'required',
        ];
    }

    public function checkVersion(): array
    {
        return [
            'version'  => 'required',
            'platform' => 'required|in:Ios,Android',
        ];
    }
}
