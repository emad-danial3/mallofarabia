<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPrintHistory extends AbstractModel
{
    use HasFactory;
      public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }
}
