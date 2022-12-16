<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ActivityLogResource;
use App\Models\Activity;
use App\Repositories\Activity\ActivityRepository;

class ActivityLogController extends Controller
{
    protected $activityRepository;

    public function __construct(ActivityRepository $activityRepository) {
        $this->authorizeResource(Activity::class);
        $this->activityRepository = $activityRepository;
    }

    public function index()
    {
        $activities = $this->activityRepository->getActivities();
        return ok_response(collectionFormat(ActivityLogResource::class, $activities));
    }
}
