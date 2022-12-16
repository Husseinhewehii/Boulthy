<?php

namespace App\Http\Resources\Tag;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowTagResource extends JsonResource
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
            'name' => $this->attributes('name')->data['name'],
            "type" => $this->type ?? "",
            "slug" => $this->slug,
            "order_column" => $this->order_column,
        ];
    }
}
