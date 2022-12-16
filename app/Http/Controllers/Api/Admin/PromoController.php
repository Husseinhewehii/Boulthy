<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Promos\PromoStore;
use App\Http\Requests\Admin\Promos\PromoUpdate;
use App\Http\Resources\Promo\PromoResource;
use App\Http\Resources\Promo\PromoResourceShow;
use App\Models\Promo;
use App\Repositories\Promo\PromoRepository;
use App\Services\PromoService;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    protected $promoRepository;
    protected $promoService;

    public function __construct(PromoRepository $promoRepository, PromoService $promoService) {
        $this->authorizeResource(Promo::class, "promo");
        $this->promoRepository = $promoRepository;
        $this->promoService = $promoService;
    }

    public function index()
    {
        return ok_response($this->all());
    }

    public function store(PromoStore $request) {
        $this->promoService->createPromo($request);
        return created_response($this->all());
    }

    public function update(PromoUpdate $request, Promo $promo) {
        $this->promoService->updatePromo($request, $promo);
        return ok_response($this->all());
    }

    public function show(Request $request, Promo $promo) {
        return ok_response(new PromoResourceShow($promo));
    }

    public function destroy(Request $request, Promo $promo) {
        $promo->delete();
        return ok_response($this->all());
    }

    private function all(){
        return collectionFormat(PromoResource::class, $this->promoRepository->getPromos());
    }
}
