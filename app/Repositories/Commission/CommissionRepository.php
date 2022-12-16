<?php

namespace App\Repositories\Commission;

use App\Models\Commission;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CommissionRepository
{
    public function getCommissions()
    {
        return QueryBuilder::for(Commission::class)
        ->allowedFilters(["user_id", "order_id"])
        ->allowedSorts(["user_id", "order_id"])
        ->paginate(10);
    }

}
