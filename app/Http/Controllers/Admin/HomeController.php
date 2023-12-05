<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
       /*
        if (Auth::guard('admin')->user())
        Auth::loginUsingId(Auth::guard('admin')->user()->id);
        */
    }

    public function home(){

        return view('AdminPanel.PagesContent.index');
    }


}
