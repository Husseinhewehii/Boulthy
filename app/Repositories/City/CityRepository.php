<?php

namespace App\Repositories\City;

use App\Models\City;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CityRepository
{
    public function getPaginatedCities($pagination = 10)
    {
        return QueryBuilder::for(City::class)
        ->allowedFilters(["name", "active", AllowedFilter::scope("price_more"), AllowedFilter::scope("price_less")])
        ->allowedSorts(["name", "active"])
        ->paginate($pagination);
    }

    public function getAllCities()
    {
        return QueryBuilder::for(City::class)
        ->allowedFilters(["name"])
        ->allowedSorts(["name"])
        ->get();
    }

}
