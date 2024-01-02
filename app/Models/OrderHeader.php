<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHeader extends AbstractModel
{
    use HasFactory;
    public function client()
    {
        return $this->belongsTo(Client::class,'client_id');
    }
    public function createdFor()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function order_lines()
    {
        return $this->hasMany(OrderLine::class,'order_id');
    }
    public function prints()
    {
        return $this->hasMany(OrderPrintHistory::class,'order_header_id');
    }
   

}
