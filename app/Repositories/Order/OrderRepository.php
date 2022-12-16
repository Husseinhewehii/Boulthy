<?php

namespace App\Repositories\Order;

use App\Models\Order;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class OrderRepository
{
    public function getOrders()
    {
        return QueryBuilder::for(Order::class)
        ->allowedFilters(["user_id", "status", "email", "phone", "payment_method", "city_id", "district_id"])
        ->allowedSorts(["id", "user_id", "status", "email", "payment_method", "city_id", "district_id"])
        ->paginate(10);
    }

}
