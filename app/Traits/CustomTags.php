<?php
namespace App\Traits;

use App\Models\Tag;

trait CustomTags{

    public function custom_tags()
    {
        return $this->belongsToMany(Tag::class, "taggables", "taggable_id", "tag_id");
    }
}
