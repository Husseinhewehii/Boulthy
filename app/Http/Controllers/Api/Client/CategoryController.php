<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use App\Repositories\Category\CategoryRepository;
use Illuminate\Http\Request;

/**
 * @group Category Module
 */
class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository) {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Get All Categories
     *
     * @header Authorization Bearer Token
     * @queryParam filter[name] Filter by name. Example: name
     * @queryParam sort Sort Field by name. Example: name
     * @queryParam filter[root] set this value to true to get root categories. Example: true
     *
     * @apiResourceCollection App\Http\Resources\Category\CategoryResource
     * @apiResourceModel App\Models\Category
     */
    public function index()
    {
        return ok_response(collectionFormat(CategoryResource::class, $this->categoryRepository->getCategories()));
    }

    /**
     * Show Category
     *
     * @apiResource App\Http\Resources\Category\CategoryResource
     * @apiResourceModel App\Models\Category
     * @responseFile 404 scenario="not found Category" responses/not_found.json
     * */
    public function show(Request $request, Category $category)
    {
        return ok_response(new CategoryResource($category));
    }
}
