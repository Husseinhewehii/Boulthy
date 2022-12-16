<?php

namespace App\Services;

use App\Constants\Media_Collections;
use App\Models\PageHeader;

class PageHeaderService
{
    public function updatePageHeader($request, $pageHeader)
    {
        add_media_item($pageHeader, $request->photo, Media_Collections::PAGE_HEADER);
    }
}
