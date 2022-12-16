<?php

namespace App\Repositories\District;

use App\Models\District;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class DistrictRepository
{
    public function getPaginatedDistricts($pagination = 10)
    {
        return QueryBuilder::for(District::class)
        ->allowedFilters(["city_id", "name", "active", AllowedFilter::scope("price_more"), AllowedFilter::scope("price_less")])
        ->allowedSorts(["name", "active"])
        ->paginate($pagination);
    }

    public function getAllDistricts()
    {
        return QueryBuilder::for(District::class)
        ->allowedFilters(["city_id", "name"])
        ->get();
    }

}
