<?php

namespace App\Services;

use App\Models\District;

class DistrictService
{
    public function createDistrict($request)
    {
        return District::create($request->validated());
    }

    public function updateDistrict($request, $district)
    {
        return tap($district)->update($request->validated());
    }
}
