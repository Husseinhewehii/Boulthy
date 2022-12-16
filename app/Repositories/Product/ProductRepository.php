<?php

namespace App\Repositories\Product;

use App\Constants\Order_Statuses;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\Filters\Filter;
use Spatie\QueryBuilder\QueryBuilder;

class ProductRepository
{
    public function getProducts()
    {
        return QueryBuilder::for(Product::class)
        ->with('media', 'tags', 'reviews', 'category')
        ->allowedFilters([
            "category_id", "name", "active", 'featured',
            AllowedFilter::scope("total_discounts_more"),
            AllowedFilter::scope("total_discounts_less"),
            AllowedFilter::scope("price_more"),
            AllowedFilter::scope("price_less"),
            AllowedFilter::scope("stock_more"),
            AllowedFilter::scope("stock_less"),
            AllowedFilter::callback('rate_more', function(Builder $query, $value){
                $query->whereHas('reviews', function (Builder $query) use ($value) {
                    $query->where('rating', '>', $value);
                });
            }),
            AllowedFilter::callback('rate_less', function(Builder $query, $value){
                $query->whereHas('reviews', function (Builder $query) use ($value) {
                    $query->where('rating', '<', $value);
                });
            }),
        ])
        ->allowedSorts(["id", "category_id", "name", "price", "active", "stock", "rate", "total_discounts"])
        ->paginate(10);
    }

    public function getProductNamesAndIDs(){
        return Product::select("id", "name")->get();
    }

    public function getBestSellingProducts(){
        return Product::join('order_items' , 'order_items.product_id', '=', 'products.id')
        ->join('orders', 'orders.id', '=', 'order_items.order_id')
        ->where('orders.status', Order_Statuses::DELIVERED)
        ->orderByRaw('SUM(quantity) DESC')
        ->groupBy('products.id')
        ->limit(5)
        ->get(['products.*']);
    }

    public function getProductsScoped($request)
    {
        $query = Product::query();

        $query->when($request->has('category_id'), function ($q) use($request) {
            return $q->where('category_id', $request->category_id);
        });

        $query->when($request->has('featured'), function ($q) use($request) {
            return $q->featured($request->featured);
        });

        $query->when($request->has('price_more'), function ($q) use($request) {
            return $q->priceMore($request->price_more);
        });

        $query->when($request->has('price_less'), function ($q) use($request) {
            return $q->priceLess($request->price_less);
        });

        $query->when($request->has('stock_more'), function ($q) use($request) {
            return $q->stockMore($request->stock_more);
        });

        $query->when($request->has('stock_less'), function ($q) use($request) {
            return $q->stockLess($request->stock_less);
        });

        $query->when($request->has('total_discounts_more'), function ($q) use($request) {
            return $q->totalDiscountsMore($request->total_discounts_more);
        });

        $query->when($request->has('total_discounts_less'), function ($q) use($request) {
            return $q->totalDiscountsLess($request->total_discounts_less);
        });

        $query->when($request->has('rate_more'), function ($q) use($request) {
            $q->whereHas('reviews', function (Builder $query_1) use ($request) {
                $query_1->where('rating', '>', $request->rate_more);
            });
        });

        $query->when($request->has('rate_less'), function ($q) use($request) {
            $q->whereHas('reviews', function (Builder $query_1) use ($request) {
                $query_1->where('rating', '<', $request->rate_less);
            });
        });

        $query->when($request->has('name'), function ($q) use($request) {
            return $q->whereLike('name', $request->name)
            ->orWhereLike('description', $request->description)
            ->orWhereLike('short_description', $request->short_description);
        });

        $query->when($request->has('id_sort'), function ($q) use($request) {
            if($request->id_sort == 'desc'){
                return $q->orderBy('id', 'desc');
            }
        });

        $query->with('media', 'tags', 'reviews', 'category');
        
        return $query->paginate(10);
    }
}


