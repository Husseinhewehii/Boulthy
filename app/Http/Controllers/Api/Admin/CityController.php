<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\City\StoreCity;
use App\Http\Requests\Admin\City\UpdateCity;
use App\Http\Resources\City\AdminCityResource;
use App\Http\Resources\City\AdminShowCityResource;
use App\Models\City;
use App\Repositories\City\CityRepository;
use App\Services\CityService;
use Illuminate\Http\Request;

/**
 * @group Admin City Module
 */
class CityController extends Controller
{
    protected $cityRepository;
    protected $cityService;

    public function __construct(CityRepository $cityRepository, CityService $cityService) {
        $this->authorizeResource(City::class, "city");
        $this->cityRepository = $cityRepository;
        $this->cityService = $cityService;
    }


    /**
     * Get All Cities
     *
     * @header Authorization Bearer Token
     * @queryParam filter[name] Filter by name. Example: name
     * @queryParam filter[price_more] Filter by price_more. Example: 500
     * @queryParam filter[price_less] Filter by price_less. Example: 500
     *
     * @apiResourceCollection App\Http\Resources\City\AdminCityResource
     * @apiResourceModel App\Models\City paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     */
    public function index(Request $request)
    {
        return ok_response($this->all($request));
    }

    /**
     * Create City
     *
     * @header Authorization Bearer Token
     *
     * @apiResourceCollection 201 App\Http\Resources\City\AdminCityResource
     * @apiResourceModel App\Models\City paginate=10
     * @responseFile 422 scenario="invalid data passed" responses/unprocessable_entity.json
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * */
    public function store(StoreCity $request)
    {
        $this->cityService->createCity($request);
        return created_response($this->all($request));
    }

    /**
     * Show City
     *
     * @apiResource App\Http\Resources\City\AdminShowCityResource
     * @apiResourceModel App\Models\City paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * @responseFile 404 scenario="not found City" responses/not_found.json
     * */
    public function show(Request $request, City $city)
    {
        return ok_response(new AdminShowCityResource($city));
    }

    /**
     * Update City
     *
     * @header Authorization Bearer Token
     *
     * @apiResourceCollection App\Http\Resources\City\AdminCityResource
     * @apiResourceModel App\Models\City paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * @responseFile 404 scenario="not found City " responses/not_found.json
     * */
    public function update(UpdateCity $request, City $city)
    {
        $this->cityService->updateCity($request, $city);
        return ok_response($this->all($request));
    }

    /**
     * Delete City
     *
     * @header Authorization Bearer Token
     *
     * @apiResourceCollection App\Http\Resources\City\AdminCityResource
     * @apiResourceModel App\Models\City paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * @responseFile 404 scenario="not found City " responses/not_found.json
     * */
    public function destroy(Request $request, City $city)
    {
        $city->delete();
        return ok_response($this->all($request));
    }

    public function all($request)
    {
        return paginatedCollectionFormat(AdminCityResource::class, $this->cityRepository->getPaginatedCities($request->pagination));
    }
}
