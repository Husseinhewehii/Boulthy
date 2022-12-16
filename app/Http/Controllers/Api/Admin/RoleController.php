<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Role\RoleStore;
use App\Http\Requests\Admin\Role\RoleUpdate;
use App\Http\Resources\RoleResource;
use App\Repositories\Role\RoleRepository;
use App\Services\RoleService;
use App\Models\SystemRole as Role;

class RoleController extends Controller
{
    protected $roleRepository;
    protected $roleService;

    public function __construct(RoleRepository $roleRepository, RoleService $roleService) {
        $this->authorizeResource(Role::class, 'role');
        $this->roleRepository = $roleRepository;
        $this->roleService = $roleService;
    }

    public function index()
    {
        return ok_response($this->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleStore $request)
    {
        $this->roleService->createRole($request);
        return created_response($this->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return ok_response(new RoleResource($role));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(RoleUpdate $request, Role $role)
    {
        $this->roleService->updateRole($request, $role);
        return ok_response($this->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        if($role->isSuperAdmin()){
            return forbidden_response();
        }

        $role->delete();
        return ok_response($this->all());
    }

    private function all(){
        return collectionFormat(RoleResource::class, $this->roleRepository->getRoles());
    }
}
