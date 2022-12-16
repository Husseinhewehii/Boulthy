<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Discount\DiscountStore;
use App\Http\Requests\Admin\Discount\DiscountUpdate;
use App\Http\Resources\Discount\CustomDiscountResource;
use App\Http\Resources\Discount\DiscountResource;
use App\Models\Discount;
use App\Repositories\Discount\DiscountRepository;
use App\Services\DiscountService;

/**
 * @group Admin Discount Module
 */
class DiscountController extends Controller
{
    protected $discountRepository;
    protected $discountService;

    public function __construct(DiscountRepository $discountRepository, DiscountService $discountService) {
        $this->authorizeResource(Discount::class, "discount");
        $this->discountRepository = $discountRepository;
        $this->discountService = $discountService;
    }

    /**
     * Get All Discount
     *
     * @header Authorization Bearer Token
     *
     * @queryParam sort Sort Field by name,active. Example: name,active
     * @queryParam filter[name] Filter by name. Example: name
     * @queryParam filter[active] Filter by active. Example: active
     * @queryParam filter[valid] Filter by valid. Example: 1
     * @queryParam filter[percentage_more] Filter by percentage. Example: 20
     * @queryParam filter[percentage_less] Filter by percentage. Example: 20
     * @queryParam filter[product.name] Filter by product name. Example: laptop
     * @queryParam filter[product.id] Filter by product id. Example: 20
     *
     * @apiResourceCollection App\Http\Resources\Discount\DiscountResource
     * @apiResourceModel App\Models\Discount paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     */
    public function index()
    {
        return ok_response($this->all());
    }


    /**
     * Create Discount
     *
     * @header Authorization Bearer Token
     *
     * @apiResourceCollection 201 App\Http\Resources\Discount\DiscountResource
     * @apiResourceModel App\Models\Discount paginate=10
     * @responseFile 422 scenario="invalid data passed" responses/unprocessable_entity.json
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * */
    public function store(DiscountStore $request)
    {
        $this->discountService->createDiscount($request);
        return created_response($this->all());
    }


    /**
     * Show Discount
     *
     * @header Authorization Bearer Token
     *
     * @apiResource App\Http\Resources\Discount\CustomDiscountResource
     * @apiResourceModel App\Models\Discount paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * @responseFile 404 scenario="not found Discount " responses/not_found.json
     * */
    public function show(Discount $discount)
    {
        return ok_response(new CustomDiscountResource($discount));
    }


    /**
     * Update Discount
     *
     * @header Authorization Bearer Token
     *
     * @apiResourceCollection App\Http\Resources\Discount\DiscountResource
     * @apiResourceModel App\Models\Discount paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * @responseFile 404 scenario="not found Discount " responses/not_found.json
     * */
    public function update(DiscountUpdate $request, Discount $discount)
    {
        $this->discountService->updateDiscount($request, $discount);
        return ok_response($this->all());
    }

   /**
     * Delete Discount
     *
     * @header Authorization Bearer Token
     *
     * @apiResourceCollection App\Http\Resources\Discount\DiscountResource
     * @apiResourceModel App\Models\Discount paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * @responseFile 404 scenario="not found Discount " responses/not_found.json
     * */
    public function destroy(Discount $discount)
    {
        $discount->delete();
        return ok_response($this->all());
    }

    public function all()
    {
        return collectionFormat(DiscountResource::class, $this->discountRepository->getDiscounts());
    }
}
