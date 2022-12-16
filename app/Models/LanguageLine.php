<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Translatable\HasTranslations;

class LanguageLine extends Model
{
    use HasFactory, HasTranslations, LogsActivity;

    protected $fillable = ['group', 'key', 'text'];
    public $translatable = ['text'];
    protected $casts = [
        'text' => 'array'
    ];

    //scopes
    public function scopeSettings($query)
    {
        $query->where('group', "settings");
    }
}
