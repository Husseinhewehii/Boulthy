<?php

namespace App\Repositories\PageHeader;

use App\Models\PageHeader;
use Spatie\QueryBuilder\QueryBuilder;

class PageHeaderRepository
{
    public function getPageHeaders()
    {
        return QueryBuilder::for(PageHeader::class)
        ->allowedFilters(['key'])
        ->paginate(10);
    }

    public function getPageHeadersWithoutPagination()
    {
        return QueryBuilder::for(PageHeader::class)
        ->allowedFilters(['key'])
        ->get();
    }

}
