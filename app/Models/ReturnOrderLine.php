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
}
