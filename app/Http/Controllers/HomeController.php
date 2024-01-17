<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
   
    public function home(){
        return view('AdminPanel.PagesContent.index');
    }


}
