<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Partner\StorePartner;
use App\Http\Requests\Admin\Partner\UpdatePartner;
use App\Http\Resources\Partner\PartnerResource;
use App\Models\Partner;
use App\Repositories\Partner\PartnerRepository;
use App\Services\PartnerService;

class PartnerController extends Controller
{
    protected $partnerRepository;
    protected $partnerService;

    public function __construct(PartnerRepository $partnerRepository, PartnerService $partnerService) {
        $this->authorizeResource(Partner::class, "partner");
        $this->partnerRepository = $partnerRepository;
        $this->partnerService = $partnerService;
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
    public function store(StorePartner $request)
    {
        $this->partnerService->createPartner($request);
        return created_response($this->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function show(Partner $partner)
    {
        return ok_response(new PartnerResource($partner));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePartner $request, Partner $partner)
    {
        $this->partnerService->updatePartner($request, $partner);
        return ok_response($this->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Partner $partner)
    {
        $partner->delete();
        return ok_response($this->all());
    }

    private function all(){
        return collectionFormat(PartnerResource::class, $this->partnerRepository->getPartners());
    }
}
