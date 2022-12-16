<?php

namespace App\Http\Resources\Vacancy;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowVacancyResource extends JsonResource
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
            'title' => $this->attributes('title')->data['title'],
            'short_description' => $this->attributes('short_description')->data['short_description'],
            'description' => $this->attributes('description')->data['description'],
            'active' => $this->active,
        ];
    }
}
