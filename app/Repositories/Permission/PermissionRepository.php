<?php

namespace App\Repositories\Permission;

use App\Models\SystemPermission as Permission;
use Spatie\QueryBuilder\QueryBuilder;

class PermissionRepository
{
    public function getPermissions()
    {
        return QueryBuilder::for(Permission::class)
        ->allowedFilters("name")
        ->allowedSorts("name")
        ->paginate(10);
    }

}
