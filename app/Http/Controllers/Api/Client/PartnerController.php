<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Partner\PartnerResource;
use App\Models\Partner;
use App\Repositories\Partner\PartnerRepository;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    protected $partnerRepository;

    public function __construct(PartnerRepository $partnerRepository) {
        $this->partnerRepository = $partnerRepository;
    }

    public function index()
    {
        return ok_response(collectionFormat(PartnerResource::class, $this->partnerRepository->getPartners()));
    }

    public function show(Partner $partner)
    {
        return ok_response(new PartnerResource($partner));
    }

}
