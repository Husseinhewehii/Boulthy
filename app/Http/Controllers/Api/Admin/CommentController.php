<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\CommentRequest;
use App\Models\Comment;
use App\Services\CommentService;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService) {
        $this->authorizeResource(Comment::class, "comment");
        $this->commentService = $commentService;
    }

    public function update(CommentRequest $request, Comment $comment)
    {
        $this->commentService->updateComment($request, $comment);
        return ok_response($this->model($comment));
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return ok_response($this->model($comment));
    }

    private function model($comment)
    {
        $model = $comment->commentable_type::findOrFail($comment->commentable_id);
        $modelNameExtracted = extractModelName($comment->commentable_type);
        $path = sprintf("\App\Http\Resources\%s\%sResource", $modelNameExtracted, $modelNameExtracted);
        return new $path($model);
    }
}
