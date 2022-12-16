<?php

namespace App\Http\Resources\Category;

use App\Http\Resources\Product\ClientShowProductResource;
use App\Http\Resources\Product\CustomProductResource;
use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'name' => $this->name,
            'active' => $this->active,
            'products' => ClientShowProductResource::collection($this->products),
            'all_products' => ClientShowProductResource::collection(Product::whereIn('id', $this->all_products())->get()),
            'children' => CategoryResource::collection($this->children),
        ];
    }
}
