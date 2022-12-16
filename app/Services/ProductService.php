<?php

namespace App\Services;

use App\Constants\Media_Collections;
use App\Models\Product;

class ProductService
{
    public function createProduct($request)
    {
        $product = Product::create($request->validated());
        add_media_item($product, $request->image, Media_Collections::PRODUCTS);
        add_multi_media_item($product, $request->images, Media_Collections::PRODUCTS_GALLERY);
        add_tags($product, $request->tag_ids);
        return $product;
    }

    public function updateProduct($request, $product)
    {
        $product->update($request->validated());
        add_media_item($product, $request->image, Media_Collections::PRODUCTS);
        add_multi_media_item($product, $request->images, Media_Collections::PRODUCTS_GALLERY);
        add_tags($product, $request->tag_ids);
        return $product;
    }

    public function likeOrUnlikeProduct($product)
    {
        $user = auth()->user();
        if($user->favorite_products->contains($product)){
            $user->favorite_products()->detach($product);
        }else{
            $user->favorite_products()->attach($product);
        }

    }

}
