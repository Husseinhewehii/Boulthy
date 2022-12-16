<?php

namespace App\Services;

use App\Models\Setting;

class SettingService
{
    public function updateSetting($request)
    {
        $item = Setting::updateOrCreate(["key"=> $request->key], $request->validated());
    }

    public function updateSettingsByKey($request)
    {
        $requestItems = $request->items;
        foreach ($requestItems as $key => $value) {
            $item = Setting::where('key', $key)->first();
            $item->update(['value' => $value]);
        }
    }
}
