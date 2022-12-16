<?php

namespace App\Observers;

use App\Models\Discount;

class DiscountObserver
{
    public function saved(Discount $discount)
    {
        $product = $discount->product;
        $product->total_discounts = $product->validDiscounts()->sum('percentage');
        $product->save();
    }
}
