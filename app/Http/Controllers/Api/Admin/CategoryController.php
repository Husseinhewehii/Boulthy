<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\CategoryStore;
use App\Http\Requests\Admin\Category\CategoryUpdate;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Category\CustomCategoryResource;
use App\Models\Category;
use App\Repositories\Category\CategoryRepository;
use App\Services\CategoryService;

/**
 * @group Admin Category Module
 */
class CategoryController extends Controller
{
    protected $categoryRepository;
    protected $categoryService;

    public function __construct(CategoryRepository $categoryRepository, CategoryService $categoryService) {
        $this->authorizeResource(Category::class, "category");
        $this->categoryRepository = $categoryRepository;
        $this->categoryService = $categoryService;
    }

    /**
     * Get All Categories
     *
     * @header Authorization Bearer Token
     * @queryParam filter[name] Filter by name. Example: name
     * @queryParam filter[active] Filter by active. Example: 1
     * @queryParam filter[root] set this value to true to get root categories. Example: true
     *
     * @apiResourceCollection App\Http\Resources\Category\CategoryResource
     * @apiResourceModel App\Models\Category paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     */
    public function index()
    {
        return ok_response($this->all());
    }

    /**
     * Create Category
     *
     * @header Authorization Bearer Token
     *
     * @apiResourceCollection 201 App\Http\Resources\Category\CategoryResource
     * @apiResourceModel App\Models\Category paginate=10
     * @responseFile 422 scenario="invalid data passed" responses/unprocessable_entity.json
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * */
    public function store(CategoryStore $request)
    {
        $this->categoryService->createCategory($request);
        return created_response($this->all());
    }

    /**
     * Show Category
     *
     * @apiResource App\Http\Resources\Category\CustomCategoryResource
     * @apiResourceModel App\Models\Category paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * @responseFile 404 scenario="not found Category" responses/not_found.json
     * */
    public function show(Category $category)
    {
        return ok_response(new CustomCategoryResource($category));
    }

    /**
     * Update Category
     *
     * @header Authorization Bearer Token
     *
     * @apiResourceCollection App\Http\Resources\Category\CategoryResource
     * @apiResourceModel App\Models\Category paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * @responseFile 404 scenario="not found Category " responses/not_found.json
     * */
    public function update(CategoryUpdate $request, Category $category)
    {
        $this->categoryService->updateCategory($request, $category);
        return ok_response($this->all());
    }

     /**
     * Delete Category
     *
     * @header Authorization Bearer Token
     *
     * @apiResourceCollection App\Http\Resources\Category\CategoryResource
     * @apiResourceModel App\Models\Category paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * @responseFile 404 scenario="not found Category " responses/not_found.json
     * */
    public function destroy(Category $category)
    {
        $category->delete();
        return ok_response($this->all());
    }

    private function all(){
        return collectionFormat(CategoryResource::class, $this->categoryRepository->getCategories());
    }
}
