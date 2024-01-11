<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PcLog extends Model
{
    use HasFactory;
     protected $fillable   = [
        'user_id',
        'ip',
        'shift',
        'pc',
        'created_at',
    ];
    public $timestamps = false;
}
