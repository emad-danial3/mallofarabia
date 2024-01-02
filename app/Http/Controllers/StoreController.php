<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StoreController extends  HomeController
{



 	public function close_shift_data()
    {

      $total_cash = 1500;
      $total_visa_recipets = 3 ;
      $total_visa_cash = 375.5 ;
      return view('AdminPanel.PagesContent.store.closing_day_data', get_defined_vars());
    }
}