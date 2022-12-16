<?php

namespace App\Http\Resources\JobApplication;

use App\Constants\Media_Collections;
use App\Http\Resources\Vacancy\VacancyResource;
use Illuminate\Http\Resources\Json\JsonResource;

class JobApplicationResource extends JsonResource
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
            'vacancy' => new VacancyResource($this->vacancy),
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'note' => $this->note,
            'cv' => $this->getFirstMediaUrl(Media_Collections::JOB_APPLICATIONS_CV),
        ];
    }
}
