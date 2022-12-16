<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Commission\CommissionResource;
use App\Models\Commission;
use App\Repositories\Commission\CommissionRepository;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    protected $commissionRepository;

    public function __construct(CommissionRepository $commissionRepository) {
        $this->commissionRepository = $commissionRepository;
    }

    public function index(Request $request)
    {
        $filter = $request->filter;
        $filter['user_id'] = auth()->id();
        $request->request->add(['filter' => $filter]);

        return ok_response($this->all());
    }

    public function show(Commission $commission)
    {
        return ok_response(new CommissionResource($commission));
    }

    public function all()
    {
        return ok_response(collectionFormat(CommissionResource::class, $this->commissionRepository->getCommissions()));
    }
}
