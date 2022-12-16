<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StaticContent\StaticContentUpdate;
use App\Http\Requests\Admin\StaticContent\StaticContentUpdateByKey;
use App\Models\LanguageLine;
use App\Services\StaticContentService;

class StaticContentController extends Controller
{
    protected $staticContentService;

    public function __construct(StaticContentService $staticContentService) {
        $this->staticContentService = $staticContentService;
    }

    public function index()
    {
        $items = LanguageLine::select(['key', 'text'])->get();
        return ok_response($items);
    }

    public function update(StaticContentUpdate $request)
    {
        if($this->authUserCanUpdate()){
            $items = $this->staticContentService->updateStaticContent($request);
            return ok_response($items);
        }
        return forbidden_response();
    }

    public function updateByKey(StaticContentUpdateByKey $request)
    {
        if($this->authUserCanUpdate()){
            $items = $this->staticContentService->updateStaticContentByKey($request);
            return ok_response($items);
        }
        return forbidden_response();
    }

    private function authUserCanUpdate(){
        return auth()->user()->can("update static_content");
    }
}
