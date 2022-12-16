<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Commission\CommissionResource;
use App\Models\Commission;
use App\Repositories\Commission\CommissionRepository;

class CommissionController extends Controller
{
    protected $commissionRepository;

    public function __construct(CommissionRepository $commissionRepository) {
        $this->authorizeResource(Commission::class, "commission");
        $this->commissionRepository = $commissionRepository;
    }

    public function index()
    {
        return ok_response($this->all());
    }

    public function show(Commission $commission)
    {
        return ok_response(new CommissionResource($commission));
    }

    public function all()
    {
        return collectionFormat(CommissionResource::class, $this->commissionRepository->getCommissions());
    }
}
