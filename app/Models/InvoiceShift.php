<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceShift extends Model
{
    use HasFactory;

      protected $fillable = [
        'shift_id','invoice_collected_id'
    ];

}
