<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;
     public $table="options";
     public $timestamps = true;
    protected $fillable = [
        'name_en','name_ar'
    ];
}
