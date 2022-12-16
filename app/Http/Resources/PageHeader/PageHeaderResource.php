<?php

namespace App\Http\Resources\PageHeader;

use App\Constants\Media_Collections;
use Illuminate\Http\Resources\Json\JsonResource;

class PageHeaderResource extends JsonResource
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
            'key' => $this->key,
            'photo' => $this->getFirstMediaUrl(Media_Collections::PAGE_HEADER) ?? "https://shahpourpouyan.com/wp-content/uploads/2018/10/orionthemes-placeholder-image-1.png",
        ];
    }
}
