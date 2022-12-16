<?php

namespace App\Repositories\JobApplication;

use App\Models\JobApplication;
use Spatie\QueryBuilder\QueryBuilder;

class JobApplicationRepository
{
    public function getJobApplications()
    {
        return QueryBuilder::for(JobApplication::class)
        ->allowedFilters(["name", "email", "note", "phone", "vacancy_id"])
        ->allowedSorts(["name", "email", "phone"])
        ->paginate(10);
    }

}
