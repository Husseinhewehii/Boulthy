<?php

namespace App\Repositories\Blog;

use App\Models\Blog;
use Spatie\QueryBuilder\QueryBuilder;

class BlogRepository
{
    public function getBlogs()
    {
        return QueryBuilder::for(Blog::class)
        ->with('media')
        ->allowedFilters(["title", "description", "short_description", "active"])
        ->allowedSorts(["id", "title", "active"])
        ->paginate(10);
    }

    public function getBlogsScoped($request)
    {
        $query = Blog::query();

        $query->when($request->has('title'), function ($q) use($request) {
            return $q->whereLike('title', $request->title)
            ->orWhereLike('description', $request->description)
            ->orWhereLike('short_description', $request->short_description);
        });

        $query->when($request->has('active'), function ($q) use($request) {
            return $q->where('active', $request->active);
        });

        $query->with('media');
        return $query->paginate(10);
    }

}


