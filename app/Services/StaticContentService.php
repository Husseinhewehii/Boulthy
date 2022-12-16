<?php

namespace App\Services;

use App\Models\LanguageLine;
use Illuminate\Support\Facades\App;

class StaticContentService
{
    public function updateStaticContent($request)
    {
        $item = LanguageLine::updateOrCreate(["key"=> $request->key], $request->validated());
        localizedFunction([$this, 'cacheAllStaticContent'], []);
        localizedFunction([$this, 'cacheGroupStaticContent'], [$item]);
        $items = cachedLocalizedArray("all_static_content");
        return $items;
    }

    public function updateStaticContentByKey($request)
    {
        $requestItems = $request->items;
        foreach ($requestItems as $key => $text) {
            $item = LanguageLine::where('key', $key)->first();
            $item->update(['text' => $text]);
            localizedFunction([$this, "cacheGroupStaticContent"], [$item]);
        }
        localizedFunction([$this, "cacheAllStaticContent"], []);
        $allItems = cachedLocalizedArray("all_static_content");
        return $allItems;
    }


    public function cacheAllStaticContent($locale){
        $allItems = LanguageLine::pluck('text', 'key')->toArray();
        cacheAndLocalizeArray($allItems, "all_static_content", $locale);
    }

    public function cacheGroupStaticContent($item, $locale){
        $groupedItems = LanguageLine::where('group', $item->group)->pluck('text', 'key')->toArray();
        cacheAndLocalizeArray($groupedItems, "all_static_content_".$item->group, $locale);
    }
//
}
