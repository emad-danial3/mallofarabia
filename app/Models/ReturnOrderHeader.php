<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnOrderHeader extends AbstractModel
{
    use HasFactory;
    public function client()
    {
        return $this->belongsTo(Client::class,'client_id');
    }
     public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }
    public function createdFor()
    {
        return $this->belongsTo(User::class,'user_id');
    }
     public function shift()
    {
        return $this->belongsTo(Shift::class,'shift_id');
    }
    public function order_lines()
    {
        return $this->hasMany(ReturnOrderLine::class,'order_id');
    }
    public function prints()
    {
        return $this->hasMany(OrderPrintHistory::class,'order_header_id');
    }
    public function  getTotalQuantities()
    {
        if($this->orderLines)
        {

            return $this->orderLines->sum('quantity');
        }
        return 0 ;
    }
    public function  getTotalOilAttribute()
    {
        if($this->order_lines)
        { 
            $totalOil = $this->order_lines->whereIn('product_id', config('constants.oil_our_ids'))->sum(function ($orderLine) {
            return $orderLine->price * $orderLine->quantity;
        });

        return $totalOil;
        }
        return 0 ;
    }


}
