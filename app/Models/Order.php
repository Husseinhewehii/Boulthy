<?php

namespace App\Models;

use App\Constants\Order_Statuses;
use App\Constants\Payment_Methods;
use App\Traits\BelongsToUserTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Order extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, BelongsToUserTrait;
    protected $fillable = [
        "full_name",
        "user_id",
        "email",
        "phone",
        "status",
        "total",
        "total_promos",
        "sub_total",
        "final_total",
        "address",
        "note",
        "payment_method",
        "fees",
        "city_id",
        "city_price",
        "district_id",
        "district_price",
    ];

    //scopes
    public function scopeOwner($query, $client_id)
    {
        return $query->where('user_id', $client_id);
    }

    public function scopeCancellable($query)
    {
        return $query->where("status", Order_Statuses::PENDING)->OrWhere("status", Order_Statuses::IN_TRANSIT);
    }

    public function scopePending($query)
    {
        return $query->where("status", Order_Statuses::PENDING);
    }

    public function scopeInTransit($query)
    {
        return $query->where("status", Order_Statuses::IN_TRANSIT);
    }

    public function scopeShipped($query)
    {
        return $query->where("status", Order_Statuses::SHIPPED);
    }

    public function scopeDelivered($query)
    {
        return $query->where("status", Order_Statuses::DELIVERED);
    }

    public function scopeCancelled($query)
    {
        return $query->where("status", Order_Statuses::CANCELLED);
    }

    public function scopeCardPayment($query)
    {
        return $query->where("payment_method", Payment_Methods::CARD_PAYMENT);
    }

    public function scopeCashOnDelivery($query)
    {
        return $query->where("payment_method", Payment_Methods::CASH_ON_DELIVERY);
    }

    public function scopeCardOnDelivery($query)
    {
        return $query->where("payment_method", Payment_Methods::CARD_ON_DELIVERY);
    }

    //relations
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function promos()
    {
        return $this->belongsToMany(Promo::class);
    }

    public function validPromos()
    {
        return $this->promos()->where('start_date', "<", now())->Where('end_date', ">", now());
    }

    public function associatePromos()
    {
        return $this->promos()->associate();
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class);
    }

    //attributes
    public function getTotalAttribute($total)
    {
        return decimalRound($total);
    }

    public function getSubTotalAttribute($sub_total)
    {
        return decimalRound($sub_total);
    }

    public function getFinalTotalAttribute($final_total)
    {
        return decimalRound($final_total);
    }

    public function total_discount()
    {
        $totalDiscount = $this->total / 100 * $this->total_promos;
        return decimalRound($totalDiscount);
    }

    public function total_fees()
    {
        return $this->fees;
    }

    //booleans
    public function belongsToThis($user)
    {
        return $this->user_id == $user->id;
    }

    public function isCardPayment()
    {
        return $this->payment_method == Payment_Methods::CARD_PAYMENT;
    }

    public function isCashOnDelivery()
    {
        return $this->payment_method == Payment_Methods::CASH_ON_DELIVERY;
    }

    public function isCardOnDelivery()
    {
        return $this->payment_method == Payment_Methods::CARD_ON_DELIVERY;
    }

    public function isOnDelivery()
    {
        return $this->isCashOnDelivery() || $this->isCardOnDelivery();
    }

    public function isCancellable()
    {
        return $this->status == Order_Statuses::IN_TRANSIT || $this->status == Order_Statuses::PENDING;
    }

    public function isInTransit()
    {
        return $this->status == Order_Statuses::IN_TRANSIT;
    }

    public function isShipped()
    {
        return $this->status == Order_Statuses::SHIPPED;
    }

    public function isCancelled()
    {
        return $this->status == Order_Statuses::CANCELLED;
    }

    public function isPending()
    {
        return $this->status == Order_Statuses::PENDING;
    }

    public function hasAssociatePromos()
    {
        return $this->promos()->associate()->count();
    }

    public function hasOrderItems()
    {
        return $this->orderItems()->count();
    }

    public function hasCommissions()
    {
        return $this->commissions()->count();
    }
}
