<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Products\ProductReview;
use App\Http\Resources\Product\ClientShowProductResource;
use App\Http\Resources\Product\CustomProductResource;
use App\Http\Resources\Product\FavoriteProductsResource;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Product\ProductNameIDResource;
use App\Http\Resources\Product\TaggedProductResource;
use App\Models\Product;
use App\Repositories\Product\ProductRepository;
use App\Services\ProductService;
use Illuminate\Http\Request;

/**
 * @group Product Module
 */
class ProductController extends Controller
{
    protected $productRepository;
    protected $productService;

    public function __construct(ProductRepository $productRepository, ProductService $productService) {
        $this->productRepository = $productRepository;
        $this->productService = $productService;
    }

    /**
     * Get All Products
     *
     * @queryParam category_id Filter by category ID. Example: 1
     * @queryParam name Filter by name. Example: laptop
     * @queryParam active Filter by active. Example: true
     * @queryParam featured Filter by featured. Example: true
     * @queryParam total_discounts_more Filter by total_discounts_more. Example: 500
     * @queryParam total_discounts_less Filter by total_discounts_less. Example: 500
     * @queryParam price_more Filter by price_more. Example: 500
     * @queryParam price_less Filter by price_less. Example: 500
     * @queryParam stock_more Filter by stock_more. Example: 500
     * @queryParam stock_less Filter by stock_less. Example: 500
     * @queryParam rate_more Filter by rate_more. Example: 500
     * @queryParam rate_less Filter by rate_less. Example: 500
     * @queryParam sort Sort Field by category_id, name, price, stock, total_discounts, rate, active. Example: category_id,name,price,stock,total_discounts,rate,active
     *
     * @apiResourceCollection App\Http\Resources\Product\TaggedProductResource
     * @apiResourceModel App\Models\Product
     */
    public function index(Request $request)
    {
        return ok_response(collectionFormat(TaggedProductResource::class, $this->productRepository->getProductsScoped($request)));
    }

    /**
     * Show Product
     *
     * @apiResource App\Http\Resources\Product\ProductResource
     * @apiResourceModel App\Models\Product paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * @responseFile 404 scenario="not found product" responses/not_found.json
     * */
    public function show(Request $request, Product $product)
    {
        return ok_response(new ClientShowProductResource($product));
    }

    /**
     * Review Product
     *
     * @header Authorization Bearer Token
     * @urlParam product integer required The ID of the product.
     *
     * @apiResource App\Http\Resources\Product\ClientShowProductResource
     * @apiResourceModel App\Models\Product paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * @responseFile 404 scenario="not found product" responses/not_found.json
     * */
    public function review(ProductReview $request, Product $product)
    {
        $product->makeOrUpdateReview(auth()->user(), $request->rating, $request->comment);
        return ok_response(new ClientShowProductResource($product));
    }

    /**
     * Like Product
     *
     * @header Authorization Bearer Token
     * @urlParam product integer required The ID of the product.
     *
     * @apiResource App\Http\Resources\Product\ClientShowProductResource
     * @apiResourceModel App\Models\Product paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * @responseFile 404 scenario="not found product" responses/not_found.json
     * */
    public function likeOrUnlike(Request $request, Product $product)
    {
        $this->productService->likeOrUnlikeProduct($product);
        return ok_response(new ClientShowProductResource($product));
    }

    /**
     * Get Favorite Products
     *
     * @header Authorization Bearer Token
     *
     * @apiResource App\Http\Resources\Product\FavoriteProductsResource
     * @apiResourceModel App\Models\Product
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * */
    public function getFavotireProducts()
    {
        return ok_response(collectionFormat(FavoriteProductsResource::class, auth()->user()->favorite_products));
    }

    /**
     * Get Products Name IDs
     *
     * @header Authorization Bearer Token
     *
     * @apiResource App\Http\Resources\Product\ProductNameIDResource
     * @apiResourceModel App\Models\Product paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * @responseFile 404 scenario="not found product" responses/not_found.json
     * */
    public function getNamesIDs()
    {
        $productNamesIDs = $this->productRepository->getProductNamesAndIDs();
        return ok_response(ProductNameIDResource::collection($productNamesIDs));
    }

    /**
     * Get Products Best Selling
     *
     * @header Authorization Bearer Token
     *
     * @apiResource App\Http\Resources\Product\ClientShowProductResource
     * @apiResourceModel App\Models\Product paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * @responseFile 404 scenario="not found product" responses/not_found.json
     * */
    public function getBestSelling()
    {
        $bestSellingProducts = $this->productRepository->getBestSellingProducts();
        return ok_response(ClientShowProductResource::collection($bestSellingProducts));
    }
}
