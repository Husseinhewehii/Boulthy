<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Tag\SearchableTagResource;
use App\Models\Tag;
use App\Repositories\Tag\TagRepository;
use Illuminate\Http\Request;

/**
 * @group Tag Module
 */
class TagController extends Controller
{
    protected $tagRepository;

    public function __construct(TagRepository $tagRepository) {
        $this->tagRepository = $tagRepository;
    }

    /**
     * Get All Tags
     *
     * @queryParam filter[name] Filter by name. Example: laptop
     *
     * @apiResourceCollection App\Http\Resources\Tag\SearchableTagResource
     * @apiResourceModel App\Models\Tag
     */
    public function index(Request $request)
    {
        return ok_response(
                collectionFormat(
                    SearchableTagResource::class,
                    $this->tagRepository->getSearchableTags($request->pagination)
                )
        );
    }
}
