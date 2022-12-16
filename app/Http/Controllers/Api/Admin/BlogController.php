<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\Admin\Blog\BlogStore;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Blog\BlogUpdate;
use App\Http\Requests\Comment\CommentRequest;
use App\Http\Resources\Blog\BlogResource;
use App\Http\Resources\Blog\BlogShowResource;
use App\Models\Blog;
use App\Repositories\Blog\BlogRepository;
use App\Services\BlogService;

class BlogController extends Controller
{
    protected $blogRepository;
    protected $blogService;

    public function __construct(BlogRepository $blogRepository, BlogService $blogService) {
        $this->authorizeResource(Blog::class, "blog");
        $this->blogRepository = $blogRepository;
        $this->blogService = $blogService;
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
    public function store(BlogStore $request)
    {
        $this->blogService->createBlog($request);
        return created_response($this->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        return ok_response(new BlogShowResource($blog));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogUpdate $request, Blog $blog)
    {
        $this->blogService->updateBlog($request, $blog);
        return ok_response($this->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();
        return ok_response($this->all());
    }

    public function comment(CommentRequest $request, Blog $blog)
    {
        auth()->user()->comment($blog, $request->comment);
        return ok_response(new BlogResource($blog));
    }

    private function all(){
        return collectionFormat(BlogResource::class, $this->blogRepository->getBlogs());
    }

    protected function resourceAbilityMap()
    {
        return [
            'comment'=> 'comment',
        ];
    }
}
