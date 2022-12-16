<?php

namespace App\Http\Controllers;

use App\Repositories\Blog\BlogRepository;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Product\ProductRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $categoryRepository;
    protected $productRepository;
    protected $blogRepository;

    public function __construct(CategoryRepository $categoryRepository, ProductRepository $productRepository, BlogRepository $blogRepository) {
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
        $this->blogRepository = $blogRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $data['categories'] = $this->categoryRepository->getCategories();
        // $data['categories'] = Category::all();
        // $data['categories'] = Category::with('products', 'children')->get();
        // $data['products'] = $this->productRepository->getProducts();
        // $data['products'] = Product::all();
        // $data['products'] = Product::with('category')->get();
        // return view('test')->with($data);
        $data['blogs'] = $this->blogRepository->getBlogsScoped($request);
        return view('test')->with($data);
    }
}
