<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityLogResource extends JsonResource
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
            "subject" => extractModelName($this->subject_type),
            "subject_id" => $this->subject_id,
            "description" => $this->description,
            "author_id" => optional($this->author)->id ?? "",
            "author_name" => optional($this->author)->name ?? "",
            "author_email" => optional($this->author)->email ?? "",
            "author_type" => optional($this->author)->type ?? "",
        ];
    }
}
