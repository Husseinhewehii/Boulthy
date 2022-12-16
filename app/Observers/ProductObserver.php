<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver
{
    public function deleting(Product $product)
    {
        $product->pendingOrderItems()->delete();
    }
}
