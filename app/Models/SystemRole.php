<?php

namespace App\Models;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Models\Role;

class SystemRole extends Role
{
    use LogsActivity;

    protected $fillable = ["name", "active", "guard_name"];

    //booleans
    public function isSuperAdmin()
    {
        return $this->name == 'super-admin';
    }
}
