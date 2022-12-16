<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Tag\TagStore;
use App\Http\Requests\Admin\Tag\TagUpdate;
use App\Http\Resources\Tag\ShowTagResource;
use App\Http\Resources\Tag\TagResource;
use App\Repositories\Tag\TagRepository;
use App\Services\TagService;
use Illuminate\Http\Request;
use App\Models\Tag;


class TagController extends Controller
{
    protected $tagRepository;
    protected $tagService;

    public function __construct(TagRepository $tagRepository, TagService $tagService) {
        $this->authorizeResource(Tag::class, "tag");
        $this->tagRepository = $tagRepository;
        $this->tagService = $tagService;
    }

    public function index()
    {
        return ok_response($this->all());
    }

    public function store(TagStore $request) {
        $this->tagService->createTag($request);
        return created_response($this->all());
    }

    public function update(TagUpdate $request, Tag $tag) {
        $this->tagService->updateTag($request, $tag);
        return ok_response($this->all());
    }

    public function show(Request $request, Tag $tag) {
        return ok_response(new ShowTagResource($tag));
    }

    public function destroy(Request $request, Tag $tag) {
        $tag->delete();
        return ok_response($this->all());
    }

    private function all(){
        return collectionFormat(TagResource::class, $this->tagRepository->getTags());
    }
}
