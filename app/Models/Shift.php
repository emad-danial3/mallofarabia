<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Auth;
class Shift extends AbstractModel
{
    use HasFactory;

    protected $hidden = ['created_at','updated_at'];

    public function orders()
    {
        return $this->HasMany(OrderHeader::class,'shift_id');
    }
    public function return_orders()
    {
        return $this->HasMany(ReturnOrderHeader::class,'shift_id');
    }
    public static function get_user_shift($pc)
    {
        $current_user_id = Auth::guard('admin')->user()->id ;
        $today = Carbon::now();
        $now = $today->toDateTimeString();
        $day = $today->format('Y-m-d');
        $create_new = false; 
        $last_shift = static::latest()->first();
        if($last_shift)
        {
            if($last_shift->user_id  == $current_user_id && $today->isSameDay( Carbon::parse($last_shift->created_at)) && $last_shift->pc == $pc && !$last_shift->ended_at)
            {
                PcLog::create([
                'ip' =>$_SERVER['REMOTE_ADDR'] ,
                'user_id' =>$current_user_id ,
                'shift' =>$last_shift->id ,
                'pc' =>$pc ,
                'created_at' =>$now,
                ]);
               return  $last_shift->id;
            }
        }
       
           
            
            $shift = static::create([
            'user_id' => $current_user_id ,
            'day' =>$day,
            'pc' =>$pc,
            'is_sent_to_oracle' =>0,
            'is_valid' =>0,
            'created_at' =>$now,
            ]);
            PcLog::create([
                'ip' =>$_SERVER['REMOTE_ADDR'] ,
                'user_id' =>$current_user_id ,
                'shift' =>$shift->id ,
                'pc' =>$pc ,
                'created_at' =>$now,
            ]);
            return  $shift->id;
        
    }
    public function cashier()
    {
        return $this->belongsTo(Admin::class,'user_id');
    }
    public function oracle_invoice()
    {
        return $this->HasOne(InvoiceShift::class,'shift_id');
    }
    public function stats()
    {
      $orders = $this->orders ;
      $return_orders = $this->return_orders ;
      $orders_stats = $this->calculate_state($orders);
      $return_stats = $this->calculate_state($return_orders);
      return  [ 
        'orders' => $orders_stats ,
        'return' => $return_stats ,
        'total' => [
            'cash' => $orders_stats['total_cash'] - $return_stats['total_cash'],
            'orders' => $orders_stats['total_orders'] - $return_stats['total_orders'],
            ]
     ];
      

      
    }
    public function calculate_state($orders)
    {
       
      $total_cash = $total_visa_cash  =  $total_visa_recipets = $total_orders = $total_quantites = $total_discount = $total_oils =  0 ;
     
      foreach ($orders as $key => $order) 
      {
        
        $total_oils+= $order->TotalOil ;
        
        $total_cash += $order->cash_amount ;
        $total_orders += $order->total_order ;
        $total_visa_cash += $order->visa_amount ;
        $total_quantites += $order->TotalQuantities ;
      
        $total_discount += $order->discount_amount ;
        if($order->payment_code)
        {
           $total_visa_recipets ++ ;
        }
      }
      return array(
        'total_oils'=>$total_oils,
        'total_cash'=>$total_cash,
        'total_visa_cash'=>$total_visa_cash,
        'total_visa_recipets'=>$total_visa_recipets,
        'total_orders'=>$total_orders,
        'total_quantites'=>$total_quantites,
        'total_discount'=>$total_discount,
        'total_orders_count'=> count($orders),
      
    );
    }
    
}
