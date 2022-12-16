<?php

namespace App\Http\Resources\Faq;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowFaqResource extends JsonResource
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
            'question' => $this->attributes('question')->data['question'],
            'answer' => $this->attributes('answer')->data['answer'],
            'active' => $this->active,
        ];
    }
}
