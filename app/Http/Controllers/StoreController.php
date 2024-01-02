<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Shift;
use App\Models\InvoiceShift;
use App\Models\OracleCollectedInvoice;
use Carbon\Carbon;
class StoreController extends  HomeController
{



 	public function close_shift_data()
    {
      $current_shift_id = session('shift_id');
      $shift = Shift::find($current_shift_id);

      $stats = $shift->stats() ;
      return view('AdminPanel.PagesContent.store.closing_shift_data', get_defined_vars());
    }

     public function close_day_data()
    {
      $today = Carbon::today()->format('Y-m-d');
      $shifts = Shift::where('day',$today)->get();
      return view('AdminPanel.PagesContent.store.closing_day_data', get_defined_vars());
        
    }
    public function send_day_orders()
    {
       $today = Carbon::today()->format('Y-m-d');
       $shifts = Shift::where('day',$today)->get();
        $total_orders =  0 ;
        foreach( $shifts as $shift )
        {
          $stats = $shift->stats() ;
          $total_orders += $stats['total_orders'] ;
        }
         $oracleInvoice = OracleCollectedInvoice::create(['total_amount' => $total_orders ]);

        foreach( $shifts as $shift )
        {
          InvoiceShift::create(['shift_id' => $shift->id ,'invoice_collected_id' => $oracleInvoice->id ]);
        }
         
    }
}