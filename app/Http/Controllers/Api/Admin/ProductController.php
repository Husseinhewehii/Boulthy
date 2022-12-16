<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\ProductStore;
use App\Http\Requests\Admin\Product\ProductUpdate;
use App\Http\Resources\Product\CustomProductResource;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\Repositories\Product\ProductRepository;
use App\Services\ProductService;

class ProductController extends Controller
{
    protected $productRepository;
    protected $productService;

    public function __construct(ProductRepository $productRepository, ProductService $productService) {
        $this->authorizeResource(Product::class, "product");
        $this->productRepository = $productRepository;
        $this->productService = $productService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ok_response($this->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStore $request)
    {
        $this->productService->createProduct($request);
        return created_response($this->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return ok_response(new CustomProductResource($product));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdate $request, Product $product)
    {
        $this->productService->updateProduct($request, $product);
        return ok_response($this->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return ok_response($this->all());
    }

    private function all(){
        return collectionFormat(ProductResource::class, $this->productRepository->getProducts());
    }
}
