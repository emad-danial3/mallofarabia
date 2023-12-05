<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded=['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'updated_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function userType()
    {
        return $this->belongsTo(AccountType::class,'account_type');
    }

    public function walletHistory()
    {
        return $this->hasOne(UserWallet::class,'user_id');
    }
    public function membership()
    {
        return $this->hasOne(UserMembership::class,'user_id');
    }
    public function addresses()
    {
        return $this->hasMany(UserAddress::class,'user_id');
    }

    public function ordersHistory()
    {
        return $this->hasMany(OrderHeader::class,'user_id');
    }

    public function notificationUnReadCount()
    {
        return $this->hasMany(UserNotification::class,'user_id');
    }
}
