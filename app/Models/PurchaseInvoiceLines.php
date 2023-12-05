<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseInvoiceLines extends AbstractModel
{
    use HasFactory;

    public function Product(){
            return $this->belongsTo(Product::class);
    }
 public function Company(){
            return $this->belongsTo(Company::class,'flag');
    }

 public function PurchaseInvoice(){
            return $this->belongsTo(PurchaseInvoices::class);
    }

}
