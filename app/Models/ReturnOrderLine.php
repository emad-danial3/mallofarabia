<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnOrderLine extends AbstractModel
{
    use HasFactory;


    public function Product(){
            return $this->belongsTo(Product::class);
    }
    public function Order(){
            return $this->belongsTo(ReturnOrderHeader::class);
    }
    protected static function boot()
    {
        parent::boot();

        
        static::creating(function ($order_line) {
            //decreace product quanitity from balance
            $product = Product::find($order_line->product_id) ;
            $product->quantity = $product->quantity + $order_line->quantity ;
            $product->stock_status = 'in stock';
            $product->save();
        });
    }
}
