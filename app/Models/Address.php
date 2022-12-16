<?php

namespace App\Models;

use App\Traits\BelongsToUserTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Translatable\HasTranslations;

class Address extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, HasTranslations, BelongsToUserTrait;
    protected $fillable = ["address", "title", "active", "user_id"];
    protected $translatable = ["title"];

    //scopes
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    //booleans
    public function belongsToThis($user)
    {
        return $this->user_id == $user->id;
    }

    //scope
    // protected static function boot()
    // {
    //     parent::boot();
    //     self::addGlobalScope(function(Builder $builder){
    //         $builder->where('user_id', auth()->id());
    //     });
    // }

}
