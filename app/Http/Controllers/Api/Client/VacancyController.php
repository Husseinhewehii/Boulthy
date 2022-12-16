<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Vacancy\VacancyResource;
use App\Models\Vacancy;
use App\Repositories\Vacancy\VacancyRepository;

class VacancyController extends Controller
{
    protected $vacancyRepository;

    public function __construct(VacancyRepository $vacancyRepository) {
        $this->vacancyRepository = $vacancyRepository;
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
    public function show(Vacancy $vacancy)
    {
        return ok_response(new VacancyResource($vacancy));
    }

    private function all(){
        return collectionFormat(VacancyResource::class, $this->vacancyRepository->getVacancies());
    }
}
