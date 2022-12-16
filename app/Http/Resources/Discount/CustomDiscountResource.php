<?php

namespace App\Http\Resources\Discount;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomDiscountResource extends JsonResource
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
            'product_id' => $this->product_id,
            'name' =>  $this->attributes('name')->data['name'],
            'percentage' => $this->percentage,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'valid' => $this->isValid(),
            'active' => $this->active,
        ];
    }
}
