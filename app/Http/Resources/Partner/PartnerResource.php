<?php

namespace App\Http\Resources\Partner;

use App\Constants\Media_Collections;
use Illuminate\Http\Resources\Json\JsonResource;

class PartnerResource extends JsonResource
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
            'active' => $this->active,
            'image' => $this->getFirstMediaUrl(Media_Collections::PARTNERS),
        ];
    }
}
