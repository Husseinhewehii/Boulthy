<?php

namespace App\Models;

use Spatie\Activitylog\Models\Activity as SpatieActivity;

class Activity extends SpatieActivity
{
    public function author()
    {
        return $this->belongsTo(User::class, 'causer_id');
    }
}
