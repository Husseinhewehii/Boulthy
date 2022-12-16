<?php

namespace App\Models;

use Actuallymab\LaravelComment\Models\Comment as LaravelComment;
use App\Constants\UserTypes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;

class Comment extends LaravelComment
{
    use LogsActivity;

    //relations
    public function commentor(){
        return $this->belongsTo(User::class, 'commented_id');
    }
    //booleans
    public function belongsToThis($user)
    {
        return $this->commented_id == $user->id;
    }
}
