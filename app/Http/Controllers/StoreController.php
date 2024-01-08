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
    public function send_day_orders($day = false)
    {

       $today = $day == false ? Carbon::today()->format('Y-m-d') : $day ;
       $shifts = Shift::where('day',$today)->get();
        
        $total_orders =  0 ;
        $all_lines = array();
        foreach( $shifts as $shift )
        {
          $stats = $shift->stats() ;
          $total_orders += $stats['total_orders'] ;
          $order_headers = $shift->orders ;
          foreach ($order_headers as $key => $header) 
          {
            
            $lines = $header->order_lines;
            foreach ($lines as $key => $line) 
            {

              $product_id = $line->product_id;
              $quantity = $line->quantity;
              $discount_rate = (string) $line->discount_rate;
              
              if(isset($all_lines[$product_id]))
              {
                  if(isset($all_lines[$product_id][$discount_rate]))
                  {
                      $all_lines[$product_id][$discount_rate]['quantity']+= $quantity ;
                  }
                  else
                  {
                      $all_lines[$product_id][$discount_rate]['quantity'] = $quantity ;
                      $all_lines[$product_id][$discount_rate]['price'] = $line->price ;
                      $all_lines[$product_id][$discount_rate]['tax'] = $line->tax ;
                  }
              }
              else
              {
                $all_lines[$product_id][$discount_rate]['quantity'] = $quantity ;
                $all_lines[$product_id][$discount_rate]['price'] = $line->price ;
                $all_lines[$product_id][$discount_rate]['tax'] = $line->tax ;
              }
            }

          }
        }
           $oracleInvoice = OracleCollectedInvoice::create(['total_amount' => $total_orders ]);

      foreach( $shifts as $shift )
        {
          InvoiceShift::create(['shift_id' => $shift->id ,'invoice_collected_id' => $oracleInvoice->id ]);
        }

        $client   = new \GuzzleHttp\Client();
        $link = config('constants.save_order_link');
        $response = $client->request('POST', $link, ['verify' => false, 'form_params' => array('items' => $all_lines,'id'=>'m-00'.$oracleInvoice->id)]);
        $products = $response->getBody();
        $products = json_decode($products, true);
        dd($products);
         
    }
}