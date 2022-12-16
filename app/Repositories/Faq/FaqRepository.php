<?php

namespace App\Repositories\Faq;

use App\Models\Faq;
use Spatie\QueryBuilder\QueryBuilder;

class FaqRepository
{
    public function getFaqs()
    {
        return QueryBuilder::for(Faq::class)
        ->allowedFilters(["questions", "answer", "active"])
        ->allowedSorts(["id", "active"])
        ->paginate(10);
    }

}


