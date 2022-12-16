<?php

namespace App\Repositories\Promo;

use App\Models\Promo;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PromoRepository
{
    public function getPromos()
    {
        return QueryBuilder::for(Promo::class)
        ->allowedFilters(["name", "active", AllowedFilter::scope("percentage_more"), AllowedFilter::scope("percentage_less"), AllowedFilter::scope('valid')])
        ->allowedSorts(["name", "active", "percentage"])
        ->paginate(10);
    }

}
