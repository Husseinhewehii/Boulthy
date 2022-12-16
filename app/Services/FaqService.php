<?php

namespace App\Services;

use App\Models\Faq;

class FaqService
{
    public function createFaq($request)
    {
        return Faq::create($request->validated());
    }

    public function updateFaq($request, $faq)
    {
        return tap($faq)->update($request->validated());

    }
}
