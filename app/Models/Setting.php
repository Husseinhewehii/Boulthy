<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Setting extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;
    protected $fillable = ["group", "key", "value", "active"];
}
