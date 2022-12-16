<?php

namespace App\Repositories\User;

use App\Models\User;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserRepository
{
    public function getUsers()
    {
        return QueryBuilder::for(User::class)
        ->allowedFilters(["id", "name", "type", "phone", "active", "email", AllowedFilter::scope('verified')])
        ->allowedSorts(["id", "name", "type", "active"])
        ->paginate(10);
    }
}
