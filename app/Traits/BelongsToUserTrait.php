<?php
namespace App\Traits;

use App\Models\User;

trait BelongsToUserTrait{

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
