<?php

namespace App\Models;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Tags\Tag as SpatieTag;

class Tag extends SpatieTag{
    use LogsActivity;

    //relations
    public function products()
    {
        return $this->belongsToMany(Product::class, "taggables", "tag_id", "taggable_id");
    }

    public function blogs()
    {
        return $this->belongsToMany(Blog::class, "taggables", "tag_id", "taggable_id");
    }
}
