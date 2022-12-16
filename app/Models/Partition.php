<?php

namespace App\Models;

use App\Constants\Media_Collections;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Partition extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, LogsActivity, InteractsWithMedia, HasTranslations;

    protected $fillable = ['title', 'active'];
    public $translatable = ['title'];

    //mutator
    public function getTitleTranslatablesAttribute(){
        return json_decode($this->attributes['title'], true);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(Media_Collections::PARTITION)->singleFile();
    }
}
