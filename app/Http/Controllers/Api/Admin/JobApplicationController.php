<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\JobApplication\JobApplicationResource;
use App\Models\JobApplication;
use App\Repositories\JobApplication\JobApplicationRepository;

class JobApplicationController extends Controller
{
    protected $jobApplicationRepository;

    public function __construct(JobApplicationRepository $jobApplicationRepository) {
        $this->authorizeResource(JobApplication::class);
        $this->jobApplicationRepository = $jobApplicationRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ok_response($this->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(JobApplication $jobApplication)
    {
        return ok_response(new JobApplicationResource($jobApplication));
    }

    private function all(){
        return collectionFormat(JobApplicationResource::class, $this->jobApplicationRepository->getJobApplications());
    }

}
