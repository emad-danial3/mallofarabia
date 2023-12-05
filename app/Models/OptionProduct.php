<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionProduct extends Model
{
    use HasFactory;
     public $table="option_product";
     public $timestamps = true;
    protected $fillable = [
        'product_id','option_id','option_value_id','quantity','price','status'
    ];

    public function option(){
       return $this->belongsTo(Option::class,'option_id');
    }
    public function product(){
       return $this->belongsTo(Product::class,'product');
    }
    public function optionValue(){
       return $this->belongsTo(OptionValue::class,'option_value_id');
    }
}
