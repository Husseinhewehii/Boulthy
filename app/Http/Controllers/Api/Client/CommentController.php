<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\CommentRequest;
use App\Models\Comment;
use App\Services\CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService) {
        $this->commentService = $commentService;
    }

    public function update(CommentRequest $request, Comment $comment)
    {
        if(!$comment->belongsToThis(auth()->user())){
            return forbidden_response();
        }

        $this->commentService->updateComment($request, $comment);
        return ok_response($this->model($comment));
    }

    public function destroy(Comment $comment)
    {
        if(!$comment->belongsToThis(auth()->user())){
            return forbidden_response();
        }

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
