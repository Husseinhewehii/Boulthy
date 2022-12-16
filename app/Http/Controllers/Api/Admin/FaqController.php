<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Faq\StoreFaq;
use App\Http\Requests\Admin\Faq\UpdateFaq;
use App\Http\Resources\Faq\FaqResource;
use App\Http\Resources\Faq\ShowFaqResource;
use App\Models\Faq;
use App\Repositories\Faq\FaqRepository;
use App\Services\FaqService;

class FaqController extends Controller
{
    protected $faqRepository;
    protected $faqService;

    public function __construct(FaqRepository $faqRepository, FaqService $faqService) {
        $this->authorizeResource(Faq::class, "faq");
        $this->faqRepository = $faqRepository;
        $this->faqService = $faqService;
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
    public function store(StoreFaq $request)
    {
        $this->faqService->createFaq($request);
        return created_response($this->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function show(Faq $faq)
    {
        return ok_response(new ShowFaqResource($faq));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFaq $request, Faq $faq)
    {
        $this->faqService->updateFaq($request, $faq);
        return ok_response($this->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();
        return ok_response($this->all());
    }

    private function all(){
        return collectionFormat(FaqResource::class, $this->faqRepository->getFaqs());
    }
}
