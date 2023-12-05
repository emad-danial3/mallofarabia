<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $table = "user_addresses";
    use HasFactory;

    public    $timestamps = true;
    protected $fillable   = [
        'user_id', 'address', 'landmark', 'floor_number', 'apartment_number', 'city_id', 'area_id', 'country_id','receiver_name','receiver_phone','prime'
    ];
     public function city()
    {
        return $this->belongsTo(City::class,'city_id');
    }
    public function area()
    {
        return $this->belongsTo(Area::class,'area_id');
    }
}
