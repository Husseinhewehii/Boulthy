<?php

namespace App\Repositories\Tag;

use App\Models\Tag;
use Spatie\QueryBuilder\QueryBuilder;

class TagRepository
{
    public function getTags()
    {
        return QueryBuilder::for(Tag::class)
        ->allowedFilters(["name", "type", "slug"])
        ->allowedSorts(["name", "type", "slug"])
        ->paginate(10);
    }

    public function getSearchableTags($pagination = 10)
    {
        return QueryBuilder::for(Tag::class)
        ->allowedFilters(["name"])
        ->with('products', 'blogs')
        ->paginate($pagination);
    }

}
