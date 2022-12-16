<?php

namespace App\Policies;

use App\Models\Blog;
use App\Models\User;

class BlogPolicy extends Policy
{
    public static $key = 'blogs';

    public function comment(User $user)
    {
        $modelComments = self::$key."_comments";
        return $user->can("update $modelComments");
    }
}
