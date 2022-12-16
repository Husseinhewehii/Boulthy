<?php

namespace App\Models;

use App\Traits\BelongsToUserTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Commission extends Model
{
    use HasFactory, LogsActivity, SoftDeletes, BelongsToUserTrait;
    protected $fillable = ["user_id", "order_id", "amount"];

}
