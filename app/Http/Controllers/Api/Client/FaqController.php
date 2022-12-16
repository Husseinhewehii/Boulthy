<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Faq\FaqResource;
use App\Models\Faq;
use App\Repositories\Faq\FaqRepository;

class FaqController extends Controller
{
    protected $faqRepository;

    public function __construct(FaqRepository $faqRepository) {
        $this->faqRepository = $faqRepository;
    }

    public function index()
    {
        return ok_response(collectionFormat(FaqResource::class, $this->faqRepository->getFaqs()));
    }

    public function show(Faq $faq)
    {
        return ok_response(new FaqResource($faq));
    }
}
