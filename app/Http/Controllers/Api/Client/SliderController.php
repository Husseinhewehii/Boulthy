<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Slider\SliderResource;
use App\Models\Slider;
use App\Repositories\Slider\SliderRepository;
use Illuminate\Http\Request;

/**
 * @group Slider Module
 */
class SliderController extends Controller
{
    protected $sliderRepository;

    public function __construct(SliderRepository $sliderRepository) {
        $this->sliderRepository = $sliderRepository;
    }

    /**
     * Get All Sliders
     */
    public function index()
    {
        return ok_response(collectionFormat(SliderResource::class, $this->sliderRepository->getSlidersWithoutPagination()));
    }
}
