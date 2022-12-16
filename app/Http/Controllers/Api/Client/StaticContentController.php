<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\LanguageLine;
use Illuminate\Http\Request;

class StaticContentController extends Controller
{
    public function index(Request $request)
    {
        if($request->group){
            return ok_response($this->getStaticContentByGroup($request->group));
        }
        return ok_response($this->getALLStaticContent());
    }

    private function getStaticContentByGroup($item_group){
        $items = cachedLocalizedArray("all_static_content_".$item_group);
        if(!$items){
            $items = LanguageLine::where('group', $item_group)->pluck('text', 'key')->toArray();
            cacheLocalizedArray($items, "all_static_content_".$item_group);
        }
        return $items;
    }

    private function getALLStaticContent(){
        $items = cachedLocalizedArray("all_static_content");
        if(!$items){
            $items = LanguageLine::pluck('text', 'key')->toArray();
            cacheLocalizedArray($items, "all_static_content");
        }
        return $items;
    }
}
