<?php

namespace App\Services;

use App\Models\SystemPermission as Permission;
use App\Models\SystemRole as Role;

class RoleService
{
    public function createRole($request)
    {
        $role = Role::create($request->validated());
        $this->syncPermissions($role, $request->permission_ids);
        return $role;
    }

    public function updateRole($request, $role)
    {
        $role->update($request->validated());
        $this->syncPermissions($role, $request->permission_ids);
        return $role;
    }

    public function syncPermissions($role, $permission_ids)
    {
        if(is_array($permission_ids)){
            $permissions = Permission::whereIn('id', $permission_ids)->get();
            $role->syncPermissions($permissions);
        }
    }

}
