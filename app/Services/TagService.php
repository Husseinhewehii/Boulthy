<?php

namespace App\Services;

use App\Models\Tag;

class TagService
{
    public function createTag($request)
    {
        $tag = Tag::create($request->validated());
        return $tag;
    }

    public function updateTag($request, $tag)
    {
        $tag->update($request->validated());
        return $tag;
    }
}
