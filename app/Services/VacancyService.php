<?php

namespace App\Services;

use App\Models\Vacancy;

class VacancyService
{
    public function createVacancy($request)
    {
        return Vacancy::create($request->validated());
    }

    public function updateVacancy($request, $vacancy)
    {
        return tap($vacancy)->update($request->validated());
    }
}
