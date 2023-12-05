<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFavourites extends AbstractModel
{
    use HasFactory;

    public    $timestamps = true;
    protected $fillable   = [
        'user_id',
        'product_id',
    ];

}
