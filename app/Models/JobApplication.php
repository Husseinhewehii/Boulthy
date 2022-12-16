<?php

namespace App\Models;

use App\Constants\Media_Collections;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class JobApplication extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, LogsActivity, InteractsWithMedia;

    protected $fillable = ["vacancy_id", "name", "email", "phone", "note"];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(Media_Collections::JOB_APPLICATIONS_CV)->singleFile();
    }

    public function vacancy()
    {
        return $this->belongsTo(Vacancy::class);
    }
}
