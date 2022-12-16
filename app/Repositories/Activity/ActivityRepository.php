<?php

namespace App\Repositories\Activity;

use App\Models\Activity;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ActivityRepository
{
    public function getActivities()
    {
        return QueryBuilder::for(Activity::class)
        ->with('author')
        ->allowedFilters(["subject", "description", "subject_id",
            'author.name', 'author.email', AllowedFilter::exact('author.id')
        ])
        ->allowedSorts(["name", "active"])
        ->paginate(10);
    }

}
