<?php

namespace App\Services;

use App\Constants\Media_Collections;
use App\Models\Blog;

class BlogService
{
    public function createBlog($request)
    {
        $blog = Blog::create($request->validated());
        add_media_item($blog, $request->image, Media_Collections::BLOGS);
        add_multi_media_item($blog, $request->images, Media_Collections::BLOGS_GALLERY);
        add_tags($blog, $request->tag_ids);
        return $blog;
    }

    public function updateBlog($request, $blog)
    {
        $blog->update($request->validated());
        add_media_item($blog, $request->image, Media_Collections::BLOGS);
        add_multi_media_item($blog, $request->images, Media_Collections::BLOGS_GALLERY);
        add_tags($blog, $request->tag_ids);
        return $blog;
    }
}
