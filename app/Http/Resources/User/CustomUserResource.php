<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user = $this['user'];
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'active' => $user->active,
            'phone' => $user->phone,
            'type' => $user->type,
            'verified' => $user->isVerified(),
            'token' => $this['token'] ?? ""
        ];
    }
}
