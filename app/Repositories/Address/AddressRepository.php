<?php

namespace App\Repositories\Address;

use App\Models\Address;
use Spatie\QueryBuilder\QueryBuilder;

class AddressRepository
{
    public function getAddresses()
    {
        return QueryBuilder::for(Address::class)
        ->allowedFilters(["address", "active", "user_id"])
        ->allowedSorts(["address", "active"])
        ->paginate(10);
    }

}
