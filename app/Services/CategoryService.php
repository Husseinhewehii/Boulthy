<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function createCategory($request)
    {
        return Category::create($request->validated());
    }

    public function updateCategory($request, $category)
    {
        return tap($category)->update($request->validated());
    }
}
