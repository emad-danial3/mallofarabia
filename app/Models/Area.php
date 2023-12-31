<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends AbstractModel
{
    use HasFactory;

    protected $hidden = ['created_at','updated_at'];

    public function city()
    {
        return $this->belongsTo(City::class,'city_id');
    }
}
