<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OracleCollectedInvoice extends AbstractModel
{
    use HasFactory;
    


    public function invoice_shifts()
    {
        return $this->HasMany(InvoiceShift::class,'invoice_collected_id');
    }
}
