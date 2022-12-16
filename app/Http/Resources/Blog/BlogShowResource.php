<?php

namespace App\Http\Resources\Blog;

use App\Constants\Media_Collections;
use App\Http\Resources\CommentResource;
use App\Http\Resources\Tag\TagResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->attributes('title')->data['title'],
            'short_description' => $this->attributes('short_description')->data['short_description'],
            'description' => $this->attributes('description')->data['description'],
            'active' => $this->active,
            'image' => $this->getFirstMediaUrl(Media_Collections::BLOGS),
            'images' => get_media_gallery_filtered($this, Media_Collections::BLOGS_GALLERY),
            'tags' => TagResource::collection($this->tags),
            'created_at' => date_format($this->created_at, constant('valid_date_format')),
            'comments' => CommentResource::collection($this->comments),
        ];
    }
}
