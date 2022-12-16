<?php

namespace App\Services;

use App\Constants\Media_Collections;
use App\Models\Partner;

class PartnerService
{
    public function createPartner($request)
    {
        $partner = Partner::create($request->validated());
        add_media_item($partner, $request->image, Media_Collections::PARTNERS);
        return $partner;
    }

    public function updatePartner($request, $partner)
    {
        $partner->update($request->validated());
        add_media_item($partner, $request->image, Media_Collections::PARTNERS);
        return $partner;
    }
}
