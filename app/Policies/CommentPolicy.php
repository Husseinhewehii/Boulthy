<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Comment $comment)
    {
        $permission = $this->getPermission($comment);
        return $comment->belongsToThis($user) && $user->can("update $permission");
    }

    public function delete(User $user, Comment $comment)
    {
        $permission = $this->getPermission($comment);

        if($comment->belongsToThis($user)){
            return $user->can("delete $permission");
        }

        if($comment->commentor->isClient()){
            return $user->can("delete client $permission");
        }

        if($comment->commentor->isAdmin()){
            return $user->can("delete admin $permission");
        }

        if($comment->commentor->isSuperAdmin()){
            return $user->can("delete super-admin $permission");
        }
    }

    private function getPermission($comment){
        $model = $comment->commentable_type::findOrFail($comment->commentable_id);
        $permission = $model->getTable()."_comments";
        return $permission;
    }
}
