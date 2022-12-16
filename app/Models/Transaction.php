<?php

namespace App\Models;

use App\Constants\TransactionEntries;
use App\Constants\TransactionTypes;
use App\Traits\BelongsToUserTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Transaction extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, BelongsToUserTrait;
    protected $fillable = ["user_id", "order_id", "entry", "type", "amount", "note"];

    //relations

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //scopes
    public function scopeCredit($query)
    {
        return $query->where("entry", TransactionEntries::CREDIT);
    }

    public function scopeDebit($query)
    {
        return $query->where("entry", TransactionEntries::DEBIT);
    }

    public function scopeSales($query)
    {
        return $query->where("type", TransactionTypes::SALES);
    }

    public function scopeRefund($query)
    {
        return $query->where("type", TransactionTypes::REFUND);
    }

    public function scopeCommission($query)
    {
        return $query->where("type", TransactionTypes::COMMISSION);
    }

    public function scopeReversion($query)
    {
        return $query->where("type", TransactionTypes::REVERSION);
    }

    //booleans
    public function belongsToThis($user)
    {
        return $this->user_id == $user->id;
    }
}
