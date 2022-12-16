<?php

namespace App\Models;

use App\Constants\PromoTypes;
use App\Traits\BelongsToUserTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Translatable\HasTranslations;

class Promo extends Model
{
    use HasFactory, HasTranslations, SoftDeletes, LogsActivity, BelongsToUserTrait;

    protected $fillable = ["name", "short_description", "description", "active", "percentage", "start_date", "end_date", "code", "user_id", "type"];
    protected $translatable = ["name", "short_description", "description"];

    //booleans
    public function isValid()
    {
        return ($this->start_date <= now() && $this->end_date >= now());
    }

    public function isExclusive()
    {
        return $this->type == PromoTypes::EXCLUSIVE;
    }

    public function isGeneric()
    {
        return $this->type == PromoTypes::GENERIC;
    }

    public function belongsToThis($user)
    {
        return $this->user_id == $user->id;
    }

    //scopes
    public function scopeValid($query, $valid)
    {
        return $valid == true ?
            $query->where('start_date', "<", now())->Where('end_date', ">", now()):
            $query->where('start_date', ">", now())->orWhere('end_date', "<", now());
    }

    public function scopePercentageMore($query, $percentage_more)
    {
        return $query->where("percentage", ">=", $percentage_more);
    }

    public function scopePercentageLess($query, $percentage_less)
    {
        return $query->where("percentage", "<=", $percentage_less);
    }

    public function scopeGeneric($query)
    {
        return $query->where("type", PromoTypes::GENERIC);
    }

    public function scopeExclusive($query)
    {
        return $query->where("type", PromoTypes::EXCLUSIVE);
    }

    public function scopeAssociate($query)
    {
        return $query->where("type", PromoTypes::ASSOCIATE);
    }

}
