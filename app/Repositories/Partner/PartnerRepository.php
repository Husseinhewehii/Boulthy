<?php

namespace App\Repositories\Partner;

use App\Models\Partner;
use Spatie\QueryBuilder\QueryBuilder;

class PartnerRepository
{
    public function getPartners()
    {
        return QueryBuilder::for(Partner::class)
        ->with('media')
        ->allowedSorts(["id", "active"])
        ->paginate(10);
    }

}


