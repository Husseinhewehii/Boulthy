<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Translatable\HasTranslations;

class District extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, HasTranslations;

    protected $fillable = ["name", "price", "active", "city_id"];
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
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
