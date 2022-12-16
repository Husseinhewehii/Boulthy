<?php

namespace App\Services;

class CommentService
{
    public function updateComment($request, $comment)
    {
        $comment->update($request->validated());
        return $comment;
    }
}
