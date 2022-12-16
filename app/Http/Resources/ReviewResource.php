<?php

namespace App\Http\Resources;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $model = strtolower(extractModelName($this->model_type));
        return [
            "id" => $this->id,
            sprintf("%s_id", $model) => $this->model_id,
            "rating" => $this->rating,
            "comment" => $this->comment ?? "",
            "reply" => $this->reply ?? "",
            "reviewer" => $this->user ? new UserResource($this->user) : $this->user_id,
        ];
    }
}
