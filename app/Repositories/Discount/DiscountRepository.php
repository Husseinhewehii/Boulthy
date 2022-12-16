<?php

namespace App\Repositories\Discount;

use App\Models\Discount;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class DiscountRepository
{
    public function getDiscounts()
    {
        return QueryBuilder::for(Discount::class)
        ->allowedFilters(["name", "active", 'product.name', AllowedFilter::scope("percentage_more"), AllowedFilter::scope("percentage_less"), AllowedFilter::exact('product.id'), AllowedFilter::scope('valid')])
        ->allowedSorts(["name", "active"])
        ->paginate(10);
    }

}
