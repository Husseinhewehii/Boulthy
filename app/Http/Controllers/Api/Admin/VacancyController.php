<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Vacancy\StoreVacancy;
use App\Http\Requests\Admin\Vacancy\UpdateVacancy;
use App\Http\Resources\Vacancy\ShowVacancyResource;
use App\Http\Resources\Vacancy\VacancyResource;
use App\Models\Vacancy;
use App\Repositories\Vacancy\VacancyRepository;
use App\Services\VacancyService;

class VacancyController extends Controller
{
    protected $vacancyRepository;
    protected $vacancyService;

    public function __construct(VacancyRepository $vacancyRepository, VacancyService $vacancyService) {
        $this->authorizeResource(Vacancy::class, 'vacancy');
        $this->vacancyRepository = $vacancyRepository;
        $this->vacancyService = $vacancyService;
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVacancy $request)
    {
        $this->vacancyService->createVacancy($request);
        return created_response($this->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vacancy  $vacancy
     * @return \Illuminate\Http\Response
     */
    public function show(Vacancy $vacancy)
    {
        return ok_response(new ShowVacancyResource($vacancy));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vacancy  $vacancy
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVacancy $request, Vacancy $vacancy)
    {
        $this->vacancyService->updateVacancy($request, $vacancy);
        return ok_response($this->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vacancy  $vacancy
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vacancy $vacancy)
    {
        $vacancy->delete();
        return ok_response($this->all());
    }

    private function all(){
        return collectionFormat(VacancyResource::class, $this->vacancyRepository->getVacancies());
    }
}
