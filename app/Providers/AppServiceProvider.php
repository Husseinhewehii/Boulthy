<?php

namespace App\Providers;

use App\Interfaces\EmailInterface;
use App\Interfaces\NotificationInterface;
use App\Interfaces\PaymentInterface;
use App\Models\Discount;
use App\Models\Product;
use App\Models\Promo;
use App\Observers\DiscountObserver;
use App\Observers\ProductObserver;
use App\Observers\PromoObserver;
use App\Observers\ReviewObserver;
use App\Services\EmailService;
use App\Services\NotificationService;
use App\Services\PayMob\PayMobService;
use DGvai\Review\Review;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(EmailInterface::class, EmailService::class);
        $this->app->bind(PaymentInterface::class, PayMobService::class);
        $this->app->bind(NotificationInterface::class, NotificationService::class);

        Review::observe(ReviewObserver::class);
        Discount::observe(DiscountObserver::class);
        Promo::observe(PromoObserver::class);
        Product::observe(ProductObserver::class);
    }
}
