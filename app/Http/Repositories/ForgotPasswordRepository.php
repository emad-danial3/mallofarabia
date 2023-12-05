<?php

namespace App\Http\Repositories;

interface ForgotPasswordRepository
{
    public function createRestPassword($data);
    public function checkValidateCode($data);
}
