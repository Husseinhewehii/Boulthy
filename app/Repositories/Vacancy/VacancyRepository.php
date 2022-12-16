<?php

namespace App\Repositories\Vacancy;

use App\Models\Vacancy;
use Spatie\QueryBuilder\QueryBuilder;

class VacancyRepository
{
    public function getVacancies()
    {
        return QueryBuilder::for(Vacancy::class)
        ->allowedFilters(["title", "description", "short_description", "active"])
        ->allowedSorts(["title", "active"])
        ->paginate(10);
    }

}
