<?php

namespace App\Services;

use App\Models\Discount;

class DiscountService
{
    public function createDiscount($request)
    {
        $discount = Discount::create($request->validated());
        return $discount;
    }

    public function updateDiscount($request, $discount)
    {
        $discount->update($request->validated());
        return $discount;
    }
}
