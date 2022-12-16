<?php

namespace App\Http\Resources\Promo;

use Illuminate\Http\Resources\Json\JsonResource;

class PromoResource extends JsonResource
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
        'name' => $this->name,
        'short_description' => $this->short_description,
        'description' => $this->description,
        'percentage' => $this->percentage,
        'start_date' => $this->start_date,
        'end_date' => $this->end_date,
        'active' => $this->active,
        'type' => $this->type,
        'code' => $this->code,
        'valid' => $this->isValid(),
        'user_id' => $this->user_id,
       ];
    }
}
