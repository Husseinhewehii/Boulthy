<?php

namespace App\Models;

use App\Constants\Media_Collections;
use App\Constants\Order_Statuses;
use App\Traits\CustomTags;
use App\Traits\TagRelatedProducts;
use DGvai\Review\Reviewable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Tags\HasTags;
use Spatie\Translatable\HasTranslations;

class Product extends Model implements HasMedia
{
    use HasFactory, HasTranslations, HasTags, SoftDeletes, LogsActivity, InteractsWithMedia, Reviewable, CustomTags, TagRelatedProducts;

    protected $fillable = ["category_id", "name", "short_description", "description", "featured", "price", "stock", "active", "rate"];
    protected $translatable = ["name", "short_description", "description"];

    //attributes

    public function getPriceAttribute($price)
    {
        return decimalRound($price);
    }

    public function discounted_price()
    {
        $discountPrice = $this->price - ($this->price / 100 * $this->total_discounts);
        return decimalRound($discountPrice);
    }

    //scopes
    public function scopeFeatured($query, $bool = true)
    {
        return $query->where("featured", $bool);
    }

    public function scopeTotalDiscountsMore($query, $total_discounts_more)
    {
        return $query->where("total_discounts", ">=", $total_discounts_more);
    }

    public function scopeTotalDiscountsLess($query, $total_discounts_less)
    {
        return $query->where("total_discounts", "<=", $total_discounts_less);
    }

    public function scopePriceMore($query, $price_more)
    {
        return $query->where("price", ">=", $price_more);
    }

    public function scopePriceLess($query, $price_less)
    {
        return $query->where("price", "<=", $price_less);
    }

    public function scopeStockMore($query, $stock_more)
    {
        return $query->where("stock", ">=", $stock_more);
    }

    public function scopeStockLess($query, $stock_less)
    {
        return $query->where("stock", "<=", $stock_less);
    }

    //relations
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function pendingOrderItems()
    {
        return $this->orderItems()->where(function($orderItem){
            return $orderItem->whereHas('order', function($order){
                return $order->where("status", Order_Statuses::PENDING);
            });
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function discounts()
    {
        return $this->hasMany(Discount::class);
    }

    public function inValidDiscounts()
    {
        return $this->hasMany(Discount::class)->where('start_date', ">", now())->orWhere('end_date', "<", now());
    }

    public function validDiscounts()
    {
        return $this->hasMany(Discount::class)->where('start_date', "<", now())->Where('end_date', ">", now());
    }

    public function isFavorite()
    {
        $user = auth()->user();
        if($user){
            return $user->favorite_products->contains($this);
        }
        return false;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(Media_Collections::PRODUCTS)->singleFile();
        $this->addMediaCollection(Media_Collections::PRODUCTS_GALLERY);
    }


}
