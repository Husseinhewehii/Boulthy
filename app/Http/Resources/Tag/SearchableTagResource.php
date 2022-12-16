<?php

namespace App\Http\Resources\Tag;

use App\Http\Resources\Blog\TaggedBlogResource;
use App\Http\Resources\Product\TaggedProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SearchableTagResource extends JsonResource
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
            "id" => $this->id,
            "name" => $this->name,
            "products" => TaggedProductResource::collection($this->products),
            "blogs" => TaggedBlogResource::collection($this->blogs),
        ];
    }
}
