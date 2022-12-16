<?php

namespace App\Services;

use App\Constants\Media_Collections;
use App\Models\Slider;

class SliderService
{
    public function createSlider($request)
    {
        $slider = Slider::create($request->validated());
        add_media_item($slider, $request->photo, Media_Collections::SLIDER);
    }
}
