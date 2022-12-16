<?php

namespace App\Http\Resources\Product;

use App\Constants\Media_Collections;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Discount\DiscountResource;
use App\Http\Resources\ReviewResource;
use App\Http\Resources\Tag\TagResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'category_id' => $this->category_id,
            'name' => $this->name,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
            'average_rate_percent' => $this->rating_percent,
            'average_rate' => (int) $this->rate,
            'active' => $this->active,
            'featured' => $this->featured,
            'is_favorite' => $this->isFavorite(),
            'total_discounts' => $this->total_discounts,
            'discounted_price' => $this->discounted_price(),
            'image' => $this->getFirstMediaUrl(Media_Collections::PRODUCTS),
            'images' => get_media_gallery_filtered($this, Media_Collections::PRODUCTS_GALLERY),
            'tags' => TagResource::collection($this->tags),
            'reviews' => ReviewResource::collection($this->reviews),
            'discounts' => DiscountResource::collection($this->discounts),
            'invalid_discounts' => DiscountResource::collection($this->inValidDiscounts),
            'valid_discounts' => DiscountResource::collection($this->validDiscounts),
        ];
    }
}
