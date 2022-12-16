<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\CommentRequest;
use App\Http\Resources\Blog\BlogResource;
use App\Models\Blog;
use App\Repositories\Blog\BlogRepository;
use Illuminate\Http\Request;

/**
 * @group Blog Module
 */
class BlogController extends Controller
{
    protected $blogRepository;

    public function __construct(BlogRepository $blogRepository) {
        $this->blogRepository = $blogRepository;
    }

    /**
     * Get All Blogs
     *
     * @queryParam filter[title] Filter by title. Example: laptop
     * @queryParam filter[active] Filter by active. Example: true
     * @queryParam sort Sort Field by title, active. Example: title,active
     *
     * @apiResourceCollection App\Http\Resources\Blog\BlogResource
     * @apiResourceModel App\Models\Blog
     */
    public function index(Request $request)
    {
        return ok_response(collectionFormat(BlogResource::class, $this->blogRepository->getBlogsScoped($request)));
    }

    /**
     * Show Blog
     *
     * @apiResource App\Http\Resources\Blog\BlogResource
     * @apiResourceModel App\Models\Blog paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * @responseFile 404 scenario="not found blog" responses/not_found.json
     * */
    public function show(Request $request, Blog $blog)
    {
        return ok_response(new BlogResource($blog));
    }

    /**
     * Comment Blog
     *
     * @header Authorization Bearer Token
     * @urlParam blog integer required The ID of the blog.
     *
     * @apiResource App\Http\Resources\Blog\BlogResource
     * @apiResourceModel App\Models\Blog paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * @responseFile 404 scenario="not found blog" responses/not_found.json
     * */
    public function comment(CommentRequest $request, Blog $blog)
    {
        auth()->user()->comment($blog, $request->comment);
        return ok_response(new BlogResource($blog));
    }
}
