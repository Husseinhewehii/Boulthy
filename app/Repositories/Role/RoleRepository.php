<?php

namespace App\Repositories\Role;

use App\Models\SystemRole as Role;
use Spatie\QueryBuilder\QueryBuilder;

class RoleRepository
{
    public function getRoles()
    {
        return QueryBuilder::for(Role::class)
        ->with('permissions')
        ->allowedFilters(["name", "active"])
        ->allowedSorts(["name", "active"])
        ->paginate(10);
    }

}
