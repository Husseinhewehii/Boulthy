<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\District\StoreDistrict;
use App\Http\Requests\Admin\District\UpdateDistrict;
use App\Http\Resources\District\AdminDistrictResource;
use App\Http\Resources\District\AdminShowDistrictResource;
use App\Models\District;
use App\Repositories\District\DistrictRepository;
use App\Services\DistrictService;
use Illuminate\Http\Request;

/**
 * @group Admin District Module
 */
class DistrictController extends Controller
{
    protected $districtRepository;
    protected $districtService;

    public function __construct(DistrictRepository $districtRepository, DistrictService $districtService) {
        $this->authorizeResource(District::class, "district");
        $this->districtRepository = $districtRepository;
        $this->districtService = $districtService;
    }


    /**
     * Get All Cities
     *
     * @header Authorization Bearer Token
     * @queryParam filter[city_id] Filter by city ID. Example: 5
     * @queryParam filter[name] Filter by name. Example: name
     * @queryParam filter[price_more] Filter by price_more. Example: 500
     * @queryParam filter[price_less] Filter by price_less. Example: 500
     *
     * @apiResourceCollection App\Http\Resources\District\AdminDistrictResource
     * @apiResourceModel App\Models\District paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     */
    public function index(Request $request)
    {
        return ok_response($this->all($request));
    }

    /**
     * Create District
     *
     * @header Authorization Bearer Token
     *
     * @apiResourceCollection 201 App\Http\Resources\District\AdminDistrictResource
     * @apiResourceModel App\Models\District paginate=10
     * @responseFile 422 scenario="invalid data passed" responses/unprocessable_entity.json
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * */
    public function store(StoreDistrict $request)
    {
        $this->districtService->createDistrict($request);
        return created_response($this->all($request));
    }

    /**
     * Show District
     *
     * @apiResource App\Http\Resources\District\AdminShowDistrictResource
     * @apiResourceModel App\Models\District paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * @responseFile 404 scenario="not found District" responses/not_found.json
     * */
    public function show(Request $request, District $district)
    {
        return ok_response(new AdminShowDistrictResource($district));
    }

    /**
     * Update District
     *
     * @header Authorization Bearer Token
     *
     * @apiResourceCollection App\Http\Resources\District\AdminDistrictResource
     * @apiResourceModel App\Models\District paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * @responseFile 404 scenario="not found District " responses/not_found.json
     * */
    public function update(UpdateDistrict $request, District $district)
    {
        $this->districtService->updateDistrict($request, $district);
        return ok_response($this->all($request));
    }

    /**
     * Delete District
     *
     * @header Authorization Bearer Token
     *
     * @apiResourceCollection App\Http\Resources\District\AdminDistrictResource
     * @apiResourceModel App\Models\District paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * @responseFile 404 scenario="not found District " responses/not_found.json
     * */
    public function destroy(Request $request, District $district)
    {
        $district->delete();
        return ok_response($this->all($request));
    }

    public function all($request)
    {
        return paginatedCollectionFormat(AdminDistrictResource::class, $this->districtRepository->getPaginatedDistricts($request->pagination));
    }
}
