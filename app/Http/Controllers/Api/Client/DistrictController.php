<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\District\DistrictResource;
use App\Http\Resources\District\ShowDistrictResource;
use App\Models\District;
use App\Repositories\District\DistrictRepository;

/**
 * @group District Module
 */
class DistrictController extends Controller
{

    protected $districtRepository;

    public function __construct(DistrictRepository $districtRepository) {
        $this->districtRepository = $districtRepository;
    }


    /**
     * Get All Districts
     *
     * @header Authorization Bearer Token
     * @queryParam filter[city_id] Filter by city. Example: 5
     * @queryParam filter[name] Filter by name. Example: name
     *
     * @apiResourceCollection App\Http\Resources\District\DistrictResource
     * @apiResourceModel App\Models\District
     */
    public function index()
    {
        return ok_response(collectionFormat(DistrictResource::class, $this->districtRepository->getAllDistricts()));
    }

    /**
     * Show District
     *
     * @apiResource App\Http\Resources\District\ShowDistrictResource
     * @apiResourceModel App\Models\District
     * @responseFile 404 scenario="not found District" responses/not_found.json
     * */
    public function show(District $district)
    {
        return ok_response(new ShowDistrictResource($district));
    }
}
