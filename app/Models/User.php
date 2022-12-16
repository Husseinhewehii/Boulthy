<?php

namespace App\Models;

use Actuallymab\LaravelComment\CanComment;
use App\Constants\Order_Statuses;
use App\Constants\UserTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable, SoftDeletes, LogsActivity, CanComment;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'active',
        'phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'otp_expiration' => 'datetime',
    ];

    public function setPasswordAttribute($pass)
    {
        if($pass){
            $this->attributes['password'] = Hash::make($pass);
        }
    }

    public function resetOTP()
    {
        $this->timestamps = false;
        $this->otp = null;
        $this->otp_expiration = null;
        $this->save();
    }

    //attributes
    public function firstAddress(){
        $firstAddress = $this->addresses()->first();
        return $firstAddress ? $firstAddress->address : "no address";
    }

    //scopes
    public function scopeAdmin($query)
    {
        return $query->where('type', UserTypes::ADMIN);
    }

    public function scopeClient($query)
    {
        return $query->where('type', UserTypes::CLIENT);
    }

    public function scopeVerified($query, $verified)
    {
        return $verified == true ?
            $query->where('email_verified_at', '!=', null):
            $query->where('email_verified_at', '=', null);
    }

    //booleans
    public function isSuperAdmin()
    {
        return $this->type == UserTypes::SUPER_ADMIN;
    }

    public function isAdmin()
    {
        return $this->type == UserTypes::ADMIN;
    }

    public function isClient()
    {
        return $this->type == UserTypes::CLIENT;
    }

    public function isVerified()
    {
        return $this->email_verified_at ? true : false;
    }

    //relations

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function orderItems()
    {
        return $this->hasManyThrough(OrderItem::class, Order::class);
    }

    public function cart()
    {
        return $this->hasManyThrough(OrderItem::class, Order::class)->where('status', Order_Statuses::PENDING);
    }

    public function favorite_products()
    {
        return $this->belongsToMany(Product::class, "user_favorite_products", "product_id", "user_id");
    }

    public function privatePromos()
    {
        return $this->hasMany(Promo::class);
    }

    public function promos()
    {
        return $this->belongsToMany(Promo::class);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }
}
