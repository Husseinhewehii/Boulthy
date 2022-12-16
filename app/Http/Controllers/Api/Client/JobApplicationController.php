<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\JobApplication\StoreJobApplication;
use App\Http\Resources\JobApplication\JobApplicationResource;
use App\Models\JobApplication;
use App\Services\JobApplicationService;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    protected $jobApplicationService;

    public function __construct(JobApplicationService $jobApplicationService) {
        $this->jobApplicationService = $jobApplicationService;
    }

    public function store(StoreJobApplication $request)
    {
        $jobApplication = $this->jobApplicationService->createJobApplication($request);
        return ok_response(new JobApplicationResource($jobApplication));
    }
}
