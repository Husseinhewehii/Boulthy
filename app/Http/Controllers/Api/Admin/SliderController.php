<?php

namespace App\Http\Controllers\Api\Admin;

use App\Constants\SliderGroups;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Slider\StoreSlider;
use App\Http\Resources\Slider\SliderResource;
use App\Models\Slider;
use App\Repositories\Slider\SliderRepository;
use App\Services\SliderService;
use Illuminate\Http\Request;

/**
 * @group Admin Slider Module
 */
class SliderController extends Controller
{
    protected $sliderRepository;
    protected $sliderService;

    public function __construct(SliderRepository $sliderRepository, SliderService $sliderService) {
        $this->authorizeResource(Slider::class, "slider");
        $this->sliderRepository = $sliderRepository;
        $this->sliderService = $sliderService;
    }

    /**
     * Get All Sliders
     *
     * @header Authorization Bearer Token
     *
     * @apiResourceCollection App\Http\Resources\Slider\SliderResource
     * @apiResourceModel App\Models\Slider paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     */
    public function index()
    {
        return ok_response($this->all());
    }

    /**
     * Create Slider
     *
     * @header Authorization Bearer Token
     *
     * @apiResourceCollection 201 App\Http\Resources\Slider\SliderResource
     * @apiResourceModel App\Models\Slider paginate=10
     * @responseFile 422 scenario="invalid data passed" responses/unprocessable_entity.json
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * */
    public function store(StoreSlider $request)
    {
        $this->sliderService->createSlider($request);
        return created_response($this->all());
    }


    /**
     * Delete Slider
     *
     * A Super Admin Slider Cannot Be Deleted
     * @header Authorization Bearer Token
     *
     * @apiResourceCollection App\Http\Resources\Slider\SliderResource
     * @apiResourceModel App\Models\Slider paginate=10
     * @responseFile 422 scenario="invalid data passed" responses/unprocessable_entity.json
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * @responseFile 404 scenario="not found Slider" responses/not_found.json
     * */
    public function destroy(Request $request, Slider $slider)
    {
        $slider->delete();
        return ok_response($this->all());
    }

    /**
     * Get Slider Groups
     *
     * Returns Array With Strings Of All Allowed Slider Groups (Array)
     * @header Authorization Bearer Token
     *
     * @responseFile 200 scenario="success" responses/ok.json
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * */
    public function getSliderGroups()
    {
        return ok_response(SliderGroups::getSliderGroupsValues());
    }

    private function all(){
        return paginatedCollectionFormat(SliderResource::class, $this->sliderRepository->getSliders());
    }
}
