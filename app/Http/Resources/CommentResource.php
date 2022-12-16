<?php

namespace App\Http\Resources;

use App\Http\Resources\User\CommentorResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            "commentable_id" => $this->commentable_id,
            "commentable_type" => extractModelName($this->commentable_type),
            "commentor" => new CommentorResource($this->commentor),
            "commented_type" => extractModelName($this->commented_type),
            "comment" => $this->comment,
            'created_at' => date_format($this->created_at, constant('valid_date_format')),
        ];
    }
}
