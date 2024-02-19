<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Shift;
use App\Models\InvoiceShift;
use App\Models\OracleCollectedInvoice;
use App\Models\OrderHeader;
use App\Models\Pc;
use Carbon\Carbon;
class StoreController extends  HomeController
{



 	public function get_pcs()
  {
     $pcs = Pc::where('is_active',1)->get();
      return view('AdminPanel.PagesContent.pcs.index', get_defined_vars());

  }
  public function update_pc_status(Request $request)
  {
    $pc_id = $request->pc_id ;
    $is_closed = $request->is_closed ;
    $pc = PC::where('id',$pc_id)->where('is_active',1)->first();
    $status = 200;
    $message = 'Done' ;
    if($pc)
    {

      $pc->is_closed = $is_closed ;
      $pc->save();
    }
    else
    {
      $status = 400;
      $message = 'this Pc is not Active' ;
    } 
    $response = [
                'status' => $status,
                'message' => $message,
                'data' => []
            ];
    return response()->json($response);

  }
  public function close_shift_data()
    {
     
      $current_shift_id = session('shift_id');
      $today = Carbon::today()->format('Y-m-d');
      $shifts = Shift::where('is_sent_to_oracle',0)->where('pc',session('current_pc'))->get();
      $orders = $return = [
        'total_cash' => 0 ,
        'total_visa_cash' => 0 ,
        'total_visa_recipets' => 0 ,
      ];
      foreach ($shifts as $key => $shift) {
        $stats = $shift->stats();

        $orders['total_cash'] += $stats['orders']['total_cash'];
        $return['total_cash'] += $stats['return']['total_cash'];


        $orders['total_visa_cash'] += $stats['orders']['total_visa_cash'];
        $return['total_visa_cash'] += $stats['return']['total_visa_cash'];


        $orders['total_visa_recipets'] += $stats['orders']['total_visa_recipets'];
        $return['total_visa_recipets'] += $stats['return']['total_visa_recipets'];

      }
      return view('AdminPanel.PagesContent.store.closing_shift_data', get_defined_vars());
    }

     public function close_day_data()
    {
    
       $today = Carbon::today()->format('Y-m-d');
       $time_now =  Carbon::today()->format('h:i A');
      $shifts = Shift::where('is_sent_to_oracle',0)->where('pc',session('current_pc'))->get();
      return view('AdminPanel.PagesContent.store.closing_day_data', get_defined_vars());
        
    }
    public function send_day_orders($oracle_invoice_id = false)
    {
      
       $today = Carbon::today()->format('Y-m-d');

       if($oracle_invoice_id)
       {
          $oracleInvoice  = OracleCollectedInvoice::where('id',$oracle_invoice_id)->first();
          if(!$oracleInvoice)
          {
             $response = [
                'status' => 400,
                'message' => 'invalid id',
                'data' => []
            ];
             return response()->json($response);
          }
          $shifts = Shift::where('is_sent_to_oracle',$oracle_invoice_id)->get();
       }
       else
       {

          $shifts = Shift::where('is_sent_to_oracle','0')->get();
       }

       $all_lines =[];
       $all_return_lines =[];
       
        $total_cash_amount =  $total_visa_amount = $total_orders = 0 ;
        $return_total_cash_amount =  $return_total_visa_amount = $return_total_orders = $total_refund = $total_quantites = $total_discount= $total_orders_count  = $total_order_oils = $total_return_oils =  0 ;
        foreach( $shifts as $shift )
        {
          if($shift->oracle_invoice && !$oracle_invoice_id)
          {
            continue ;
          }
          $stats = $shift->stats() ;
          
          $total_orders += $stats['orders']['total_orders'] ;
          $return_total_orders += $stats['return']['total_orders'] ;

          $total_cash_amount += $stats['orders']['total_cash'] ;
          $return_total_cash_amount += $stats['return']['total_cash'] ;


          $total_order_oils += $stats['orders']['total_oils'] ;
          $total_return_oils += $stats['return']['total_oils'] ;



          $total_visa_amount += $stats['orders']['total_visa_cash'] ;
          $return_total_visa_amount += $stats['return']['total_visa_cash'] ;

          $total_refund +=  $stats['return']['total_orders']  ;
          $total_discount+= $stats['orders']['total_discount'] ;
          $total_orders_count+= $stats['orders']['total_orders_count'] ;
          $total_quantites+= $stats['orders']['total_quantites'] ;
          $order_headers = $shift->orders ;
          $return_order_headers = $shift->return_orders ;
          $all_lines = $this->map_item($order_headers,$all_lines);
          $all_return_lines = $this->map_item($return_order_headers,$all_return_lines);
         
        }
        $res =array();
        if(!empty($all_lines) || !empty($all_return_lines) )
        {
          $invoice_average_amount = $total_orders / $total_orders_count ;
          $invoice_average_quantity = $total_quantites / $total_orders_count ;
          if($oracle_invoice_id)
          {
           
            if($oracleInvoice->total_orders != $total_orders)
            {
               $response = [
                'status' => 400,
                'message' => 'total != total someone changed orders data',
                'data' => []
            ];
             return response()->json($response);
            }
              $oracle_id = $oracleInvoice->oracle_id ; 
              $oracleInvoice->total_orders = $total_orders;
              $oracleInvoice->total_orders_oil = $total_order_oils;
              $oracleInvoice->total_return_orders_oil = $total_return_oils;
              $oracleInvoice->total_cash_amount = $total_cash_amount;
              $oracleInvoice->total_visa_amount = $total_visa_amount;

              $oracleInvoice->return_total_orders = $return_total_orders;
              $oracleInvoice->return_total_cash_amount = $return_total_cash_amount;
              $oracleInvoice->return_total_visa_amount = $return_total_visa_amount;

              $oracleInvoice->total_quantites = $total_quantites;
              $oracleInvoice->total_orders_count = $total_orders_count;
              $oracleInvoice->total_discount = $total_discount;
              $oracleInvoice->total_refund = $total_refund;
              $oracleInvoice->invoice_average_amount = $invoice_average_amount;
              $oracleInvoice->invoice_average_quantity = $invoice_average_quantity;
              $oracleInvoice->updated_by = session('user_id') ;
              $oracleInvoice->save();
          }
          else
          {

              $oracleInvoice = OracleCollectedInvoice::create([
                'total_orders' => $total_orders,
                'total_orders_oil' => $total_order_oils,
                'total_return_orders_oil' => $total_return_oils,
                'total_cash_amount' => $total_cash_amount,
                'total_visa_amount' => $total_visa_amount,

                'return_total_orders' => $return_total_orders,
                'return_total_cash_amount' => $return_total_cash_amount,
                'return_total_visa_amount' => $return_total_visa_amount,

                'total_quantites' => $total_quantites,
                'total_orders_count' => $total_orders_count,
                'total_discount' => $total_discount,
                'total_refund' => $total_refund,
                'invoice_average_amount' => $invoice_average_amount,
                'invoice_average_quantity' => $invoice_average_quantity,
                'day' => $today,
                'created_by' => session('user_id'),
                 ]);

              foreach( $shifts as $shift )
              { 

                InvoiceShift::create(['shift_id' => $shift->id ,'invoice_collected_id' => $oracleInvoice->id ]);
                $shift->is_sent_to_oracle = $oracleInvoice->id ;
                $shift->ended_at = Carbon::now()->toDateTimeString() ;
                $shift->save();
              }
              $oracle_id ='M-00'.$oracleInvoice->id ; 
              $oracleInvoice->oracle_id =  $oracle_id ;
              $oracleInvoice->save() ;
          }
          $client   = new \GuzzleHttp\Client();
          $link = config('constants.save_order_link');
          $response = $client->request('POST', $link, ['verify' => false, 'form_params' => array(
            'items' => $all_lines,
            'return_items' => $all_return_lines,
            'id'=> $oracle_id,
          'total_orders' => $total_orders )]);
          
          $res = $response->getBody();
          $res = json_decode($res, true);
        }
          
         $response = [
                'status' => 200,
                'message' => "done",
                'server_response' => $res,
                'data' => []
            ];
            return response()->json($response);
    }
    function map_item($order_headers,$all_lines)
    {
       foreach ($order_headers as $key => $header) 
          {

            $lines = $header->order_lines;
            foreach ($lines as $key => $line) 
            {

              $product_id = (int) $line->product->oracle_short_code;
              $our_product_id = (int) $line->product->id;
              //don't send items with shortcodes to oracle
              if(in_array($our_product_id,config('constants.oil_our_ids')))
              {
                continue ;
              }
              $quantity = $line->quantity;
              $discount_rate =  $line->discount_rate;
              $tax_value = ( $line->tax / 100 ) *  $line->price *   $quantity  ;
              $total =    ( $quantity * $line->price ) + $tax_value  ;
              $unit_price = $line->price ;
              $unit_taxt_percetange = $line->tax ;
              $unit_price_before_tax_before_discount = round($line->price * 100/(100 +$unit_taxt_percetange ),6) ;
              
             // keep in mind after making discounts remove line->price as it will be after discount or before idk just get the meaning unit_price_before_tax_before_discount
              $unit_price_before_tax_after_discount = $unit_price_before_tax_before_discount ;
              if(isset($all_lines[$product_id]))
              {
                 
                  if(isset($all_lines[$product_id][$unit_price][$discount_rate]))
                  {
                      $all_lines[$product_id][$unit_price][$discount_rate]['quantity']+= $quantity ;
                  }
                  else
                  {
                    $all_lines[$product_id][$unit_price][$discount_rate]['quantity'] = $quantity ;
                    $all_lines[$product_id][$unit_price][$discount_rate]['price'] = $line->price ;
                    $all_lines[$product_id][$unit_price][$discount_rate]['upbtbd'] = $unit_price_before_tax_before_discount ;
                    $all_lines[$product_id][$unit_price][$discount_rate]['upbtad'] = $unit_price_before_tax_after_discount ;
                    $all_lines[$product_id][$unit_price][$discount_rate]['pbd'] = $line->price_before_discount ;
                    $all_lines[$product_id][$unit_price][$discount_rate]['tax'] = $tax_value;
                    $all_lines[$product_id][$unit_price][$discount_rate]['total'] = $total;
                  }
              }
              else
              {
                $all_lines[$product_id][$unit_price][$discount_rate]['quantity'] = $quantity ;
                $all_lines[$product_id][$unit_price][$discount_rate]['price'] = $line->price ;
                $all_lines[$product_id][$unit_price][$discount_rate]['upbtbd'] = $unit_price_before_tax_before_discount ;
                    $all_lines[$product_id][$unit_price][$discount_rate]['upbtad'] = $unit_price_before_tax_after_discount ;
                $all_lines[$product_id][$unit_price][$discount_rate]['pbd'] = $line->price_before_discount ;
                $all_lines[$product_id][$unit_price][$discount_rate]['tax'] =  $tax_value;
                $all_lines[$product_id][$unit_price][$discount_rate]['total'] = $total;
              }
            }

          }
          return $all_lines ;
    }
    function send_invoice_again(Request $request)
    {
     
      $id = $request->id ;
      if(session('user_id') != 1){
        $response = [
                'status' => 400,
                'message' => "not allowed",
                'data' => []
            ];
            return response()->json($response);
      }
      
       
      return $this->send_day_orders($id);
      

    }
    function send_invoices_again(Request $request)
    {
     
      $id = $request->id ;
      if(env('APP_ENV') === 'production'){
        $response = [
                'status' => 400,
                'message' => "cant do that in production",
                'data' => []
            ];
            return response()->json($response);
      }
      $shifts = Shift::where('is_sent_to_oracle', $id)->get();

      foreach ($shifts as $key => $shift) 
      {
        $shift->update(['is_sent_to_oracle' => 0]);
      }
      $invoice = OracleCollectedInvoice::find($id);
      if($invoice) $invoice->invoice_shifts()->delete();
       
      $this->send_day_orders();
       $response = [
                'status' => 200,
                'message' => "done",
                'data' => []
            ];
            return response()->json($response);

    }
  }
