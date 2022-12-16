<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Translatable\HasTranslations;

class Discount extends Model
{
    use HasFactory, HasTranslations, SoftDeletes, LogsActivity;

    protected $fillable = ["name", "active", "product_id", "percentage", "start_date", "end_date"];
    public $translatable = ["name"];


    //booleans
    public function isValid()
    {
        return ($this->start_date <= now() && $this->end_date >= now());
    }

    //scopes
    public function scopeValid($query, $valid)
    {
        return $valid == true ?
            $query->where('start_date', "<", now())->Where('end_date', ">", now()):
            $query->where('start_date', ">", now())->orWhere('end_date', "<", now());
    }

    //relations
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
