<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Translatable\HasTranslations;

class Vacancy extends Model
{
    use HasFactory, HasTranslations, SoftDeletes, LogsActivity;

    protected $fillable = ["title", "short_description", "description", "active"];
    protected $translatable = ["title", "short_description", "description"];

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }
}
