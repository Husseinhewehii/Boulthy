<?php

namespace App\Http\Resources\OrderItem;

use App\Constants\Media_Collections;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
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
            "order_id" => $this->order_id,
            "product_id" => $this->product_id,
            "product_name" => optional($this->product)->name,
            "quantity" => $this->quantity,
            "price" => $this->price,
            "discounted_price" => optional($this->product)->discounted_price(),
            "product_total_discounts" => $this->product_total_discounts,
            "total" => $this->total,
            "product_image" => optional($this->product)->getFirstMediaUrl(Media_Collections::PRODUCTS)
        ];
    }
}
