<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Translatable\HasTranslations;

class City extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, HasTranslations;

    protected $fillable = ["name", "price", "active"];
    protected $translatable = ["name"];

    //scopes
    public function scopePriceMore($query, $price_more)
    {
        return $query->where("price", ">=", $price_more);
    }

    public function scopePriceLess($query, $price_less)
    {
        return $query->where("price", "<=", $price_less);
    }

    //relations
    public function districts()
    {
        return $this->hasMany(District::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
