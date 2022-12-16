<?php

namespace App\Repositories\OrderItem;

use App\Models\OrderItem;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class OrderItemRepository
{
    public function getOrderItems()
    {
        return QueryBuilder::for(OrderItem::class)
        // ->allowedFilters(["name", "active", AllowedFilter::scope("percentage_more"), AllowedFilter::scope("percentage_less"), AllowedFilter::scope('valid')])
        // ->allowedSorts(["name", "active", "percentage"])
        ->paginate(10);
    }

}
