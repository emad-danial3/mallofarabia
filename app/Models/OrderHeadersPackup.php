<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHeadersPackup extends Model
{
    use HasFactory;

    public $table="order_headers_packups";
    public $timestamps = true;
    protected $fillable = [
        'old_id','payment_code','total_order', 'user_id','created_for_user_id','order_type', 'shipping_amount','address','city',
        'area','building_number','landmark', 'floor_number','apartment_number', 'payment_status','order_status','shipping_date', 'delivery_date','wallet_status','payment_paid_date','gift_category_id',
    ];
}
