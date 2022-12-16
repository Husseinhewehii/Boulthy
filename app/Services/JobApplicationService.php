<?php

namespace App\Services;

use App\Constants\Media_Collections;
use App\Models\JobApplication;

class JobApplicationService
{
    public function createJobApplication($request)
    {
        $jobApplication = JobApplication::create($request->validated());
        add_media_item($jobApplication, $request->cv, Media_Collections::JOB_APPLICATIONS_CV);
        return $jobApplication;
    }
}
