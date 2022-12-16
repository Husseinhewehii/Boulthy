<?php

namespace App\Repositories\Category;

use App\Models\Category;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CategoryRepository
{
    public function getCategories()
    {
        return QueryBuilder::for(Category::class)
        ->with('products', 'children')
        ->allowedFilters(["name", "active", AllowedFilter::exact('parent_id'), AllowedFilter::scope("root")])
        ->allowedSorts(["name", "active"])
        ->paginate(10);
    }

}
