<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionValue extends Model
{
    use HasFactory;
     public $table="option_values";
     public $timestamps = true;
    protected $fillable = [
        'option_id','name_ar','name_en'
    ];

    public function option(){
       return $this->belongsTo(Option::class,'option_id');
    }
}
