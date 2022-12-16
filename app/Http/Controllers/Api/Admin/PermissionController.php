<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use App\Repositories\Permission\PermissionRepository;
use App\Models\SystemPermission as Permission;

class PermissionController extends Controller
{
    protected $permissionRepository;

    public function __construct(PermissionRepository $permissionRepository) {
        $this->authorizeResource(Permission::class, 'permission');
        $this->permissionRepository = $permissionRepository;
    }

    public function index()
    {
        return ok_response(collectionFormat(PermissionResource::class, $this->permissionRepository->getPermissions()));
    }

}
