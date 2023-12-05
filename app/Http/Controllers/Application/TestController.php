<?php

namespace App\Http\Controllers\Application;

use Illuminate\Http\Request;

class TestController extends HomeController
{

    public function index(Request  $request)
    {
       return 1/0;
    }
}
