<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends AbstractModel
{
    use HasFactory;

    protected $hidden = ['created_at','updated_at'];

    public function country()
    {
        return $this->belongsTo(Country::class,'country_id');
    }
}
