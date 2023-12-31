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
    public static function get_user_shift()
    {
        $current_user_id = Auth::guard('admin')->user()->id ;
        $today = Carbon::now();
        $day = $today->format('Y-m-d');
        $create_new = false; 
        $last_shift = static::latest()->first();
        if($last_shift)
        {
            if($last_shift->user_id  == $current_user_id && $today->isSameDay( Carbon::parse($last_shift->created_at)) )
            {
               return  $last_shift->id;
            }
        }
       
            $now = $today->toDateTimeString();
            
            $shift = static::create([
            'user_id' => $current_user_id ,
            'day' =>$day,
            'cerated_at' =>$now,
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

      $total_cash = $total_visa_cash  =  $total_visa_recipets = $total_orders =  0 ;

      
      foreach ($orders as $key => $order) 
      {
        $total_cash += $order->cash_amount ;
        $total_orders += $order->total_order ;
        $total_visa_cash += $order->visa_amount ;
        if($order->payment_code)
        {
           $total_visa_recipets ++ ;
        }
      }
      return array(
        'total_cash'=>$total_cash,
        'total_visa_cash'=>$total_visa_cash,
        'total_visa_recipets'=>$total_visa_recipets,
        'total_orders'=>$total_orders,
    );
    }
    
}
