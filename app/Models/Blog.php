<?php

namespace App\Models;

use Actuallymab\LaravelComment\Contracts\Commentable;
use Actuallymab\LaravelComment\HasComments;
use App\Constants\Media_Collections;
use App\Traits\CustomTags;
use App\Traits\TagRelatedProducts;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Tags\HasTags;
use Spatie\Translatable\HasTranslations;

class Blog extends Model implements HasMedia, Commentable
{
    use HasFactory, HasTranslations, SoftDeletes, LogsActivity, InteractsWithMedia, HasTags, HasComments, CustomTags, TagRelatedProducts;

    protected $fillable = ["title", "short_description", "description", "active"];
    protected $translatable = ["title", "short_description", "description"];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(Media_Collections::BLOGS)->singleFile();
        $this->addMediaCollection(Media_Collections::BLOGS_GALLERY);
    }

    public function scopeWhereLike($query, $column, $value)
    {
        return $query->where($column, 'like', '%'.$value.'%');
    }

    public function scopeOrWhereLike($query, $column, $value)
    {
        return $query->orWhere($column, 'like', '%'.$value.'%');
    }
}
