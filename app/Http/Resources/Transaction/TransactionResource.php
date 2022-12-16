<?php

namespace App\Http\Resources\Transaction;

use App\Http\Resources\User\CommentorResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            "user" => new CommentorResource($this->user),
            "order_id" => $this->order_id,
            "entry" => $this->entry,
            "type" => $this->type,
            "amount" => $this->amount,
            "note" => $this->note,
        ];
    }
}
