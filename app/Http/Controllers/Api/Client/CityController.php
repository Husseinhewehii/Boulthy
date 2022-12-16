<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\City\CityResource;
use App\Http\Resources\City\ShowCityResource;
use App\Models\City;
use App\Repositories\City\CityRepository;
use Illuminate\Http\Request;

/**
 * @group City Module
 */
class CityController extends Controller
{

    protected $cityRepository;

    public function __construct(CityRepository $cityRepository) {
        $this->cityRepository = $cityRepository;
    }


    /**
     * Get All Cities
     *
     * @header Authorization Bearer Token
     * @queryParam filter[name] Filter by name. Example: name
     * @queryParam sort Sort Field by name. Example: name
     *
     * @apiResourceCollection App\Http\Resources\City\CityResource
     * @apiResourceModel App\Models\City
     */
    public function index()
    {
        return ok_response(collectionFormat(CityResource::class, $this->cityRepository->getAllCities()));
    }

    /**
     * Show City
     *
     * @apiResource App\Http\Resources\City\ShowCityResource
     * @apiResourceModel App\Models\City
     * @responseFile 404 scenario="not found City" responses/not_found.json
     * */
    public function show(City $city)
    {
        return ok_response(new ShowCityResource($city));
    }
}
