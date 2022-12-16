<?php
namespace App\Traits;

use App\Models\Product;

trait TagRelatedProducts{
    public function tag_related_products()
    {
        $related_products = [];
        foreach ($this->custom_tags as $tag) {
            $related_products = array_merge($tag->products()->pluck('id')->toArray(), $related_products);
        }
        $related_products = array_filter(array_unique($related_products), function($product_id){
            return $this->id != $product_id;
        });
        return Product::whereIn("id", $related_products)->get();
        // return Product::where("category_id", $this->category_id)->where("id", "!=", $this->id)->get();
    }
}
