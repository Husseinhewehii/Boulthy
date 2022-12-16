<?php

namespace App\Services;

use App\Models\City;

class CityService
{
    public function createCity($request)
    {
        return City::create($request->validated());
    }

    public function updateCity($request, $city)
    {
        return tap($city)->update($request->validated());
    }
}
