<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
   
    public function home(){
    if(
        session('current_user_role') == 'accountant')
    {
    return redirect()->route('sale_item_report_data');
    }
        return view('AdminPanel.PagesContent.index');
    }


}
