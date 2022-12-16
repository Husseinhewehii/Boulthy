<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setting\UpdateSetting;
use App\Http\Requests\Admin\Setting\UpdateSettingByKey;
use App\Http\Resources\Setting\SettingResource;
use App\Models\Setting;
use App\Repositories\Setting\SettingRepository;
use App\Services\SettingService;

class SettingController extends Controller
{
    protected $settingRepository;
    protected $settingService;

    public function __construct(SettingRepository $settingRepository, SettingService $settingService) {
        $this->authorizeResource(Setting::class, 'setting');
        $this->settingRepository = $settingRepository;
        $this->settingService = $settingService;
    }

    public function index()
    {
        return ok_response($this->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        return ok_response(new SettingResource($setting));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function updateSetting(UpdateSetting $request)
    {
        $this->settingService->updateSetting($request);
        return ok_response($this->all());
    }

    public function updateSettingsByKey(UpdateSettingByKey $request)
    {
        $this->settingService->updateSettingsByKey($request);
        return ok_response($this->all());
    }

    private function all(){
        return collectionFormat(SettingResource::class, $this->settingRepository->getSettings());
    }

}
