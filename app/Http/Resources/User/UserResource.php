<?php

namespace App\Http\Resources\User;

use App\Http\Resources\RoleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email' => $this->email,
            'active' => $this->active,
            'phone' => $this->phone,
            'type' => $this->type,
            'verified' => $this->isVerified(),
            'roles' => RoleResource::collection($this->roles),
        ];
    }
}
