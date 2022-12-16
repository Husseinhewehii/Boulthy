<?php

namespace App\Http\Resources\Category;

use App\Http\Resources\Product\CustomProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomCategoryResource extends JsonResource
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
            'parent_id' => $this->parent_id,
            'name' => $this->attributes('name')->data['name'],
            'active' => $this->active,
            'products' => CustomProductResource::collection($this->products),
            'children' => CategoryResource::collection($this->children),
        ];
    }
}
