<?php

use App\Http\Controllers\Api\Client\AddressController;
use App\Http\Controllers\Api\Client\StaticContentController;
use App\Http\Controllers\Api\Client\AuthController;
use App\Http\Controllers\Api\Client\BlogController;
use App\Http\Controllers\Api\Client\CategoryController;
use App\Http\Controllers\Api\Client\CityController;
use App\Http\Controllers\Api\Client\CommentController;
use App\Http\Controllers\Api\Client\CommissionController;
use App\Http\Controllers\Api\Client\CommunicationController;
use App\Http\Controllers\Api\Client\DistrictController;
use App\Http\Controllers\Api\Client\FaqController;
use App\Http\Controllers\Api\Client\JobApplicationController;
use App\Http\Controllers\Api\Client\OrderController;
use App\Http\Controllers\Api\Client\OrderItemController;
use App\Http\Controllers\Api\Client\PartnerController;
use App\Http\Controllers\Api\Client\PaymentMethodController;
use App\Http\Controllers\Api\Client\ProductController;
use App\Http\Controllers\Api\Client\SubscriptionController;
use App\Http\Controllers\Api\Client\TransactionController;
use App\Http\Controllers\Api\Client\VacancyController;
use App\Http\Controllers\Api\Client\WalletController;
use App\Http\Controllers\Api\OTPController;
use App\Services\PayMob\PayMobCallBack;

use App\Http\Controllers\Api\Client\PageHeaderController;
use App\Http\Controllers\Api\Client\PartitionController;
use App\Http\Controllers\Api\Client\SliderController;
use App\Http\Controllers\Api\Client\TagController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group([
    'prefix' => LaravelLocalization::setLocale()
    ], function(){

        Route::get('/sliders', [SliderController::class, 'index']);
        Route::get('/partitions', [PartitionController::class, 'index']);
        Route::get('/pageHeaders', [PageHeaderController::class, 'index']);

        Route::get('/static-content', [StaticContentController::class, 'index'])->name('static.content.index');
        Route::post('/login', [AuthController::class, 'login'])->name('login');
        Route::post('/register', [AuthController::class, 'register'])->name('register');

        Route::post('/communicate', [CommunicationController::class, 'communicate'])->name('communications.sendEmail');
        Route::post('/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscriptions.subscribe');
        Route::post('send-reset-password-link', [AuthController::class, 'sendResetPasswordLink']);
        Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset.password');

        Route::resource('/categories', CategoryController::class)->only(['index', 'show']);
        Route::resource('/blogs', BlogController::class)->only(['index', 'show']);
        Route::resource('/cities', CityController::class)->only(['index', 'show']);
        Route::resource('/districts', DistrictController::class)->only(['index', 'show']);
        Route::resource('/tags', TagController::class)->only(['index']);

        Route::resource('/vacancies', VacancyController::class)->only(['index', 'show']);
        Route::resource('/partners', PartnerController::class)->only(['index', 'show']);
        Route::resource('/job-applications', JobApplicationController::class)->only(['store']);
        Route::resource('/faqs', FaqController::class)->only(['index', 'show']);

        Route::get('/products/names-ids', [ProductController::class, "getNamesIDs"])->name('products.names.ids');
        Route::get('/products/best-selling', [ProductController::class, "getBestSelling"])->name('products.best.selling');
        Route::middleware('optional_auth')->group(function(){
            Route::resource('/products', ProductController::class)->only(['index', 'show']);
        });

        Route::post('/paymob/callback/processed', [PayMobCallBack::class, 'processedCallback']);

        Route::middleware('auth:api')->group(function(){
            Route::middleware('OTP')->group(function(){
                Route::post('verify', [OTPController::class, 'verify']);
                Route::post('send-verification-code', [OTPController::class, 'sendVerificationCode']);
            });

            Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
            Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change.password');

            Route::middleware('Verified')->group(function () {
                Route::get('/test', function(){ echo "client auth and ver";});

                Route::post('/products/review/{product}', [ProductController::class, 'review'])->name('products.review');
                Route::post('/products/like-or-unlike/{product}', [ProductController::class, 'likeOrUnlike'])->name('products.likeOrUnlike');

                Route::post('/blogs/{blog}/comments', [BlogController::class, 'comment'])->name('blogs.comment');
                Route::resource('/comments', CommentController::class)->only(['update', 'destroy']);

                Route::resource('/addresses', AddressController::class)->only(['index', 'store', 'update', 'destroy', 'show']);

                Route::resource('/transactions', TransactionController::class)->only(['index', 'show']);
                Route::resource('/wallet', WalletController::class)->only(['show']);
                Route::resource('/commissions', CommissionController::class)->only(['index', 'show']);

                Route::get('cart', [OrderItemController::class, 'index'])->name('orderItems.index');
                Route::post('add-to-cart', [OrderItemController::class, 'addToCart'])->name('orderItems.addToCart');
                Route::delete('delete-from-cart/{orderItem}', [OrderItemController::class, 'deleteFromCart'])->name('orderItems.deleteFromCart');

                Route::resource('/orders', OrderController::class)->only(['index', 'show', 'update']);
                Route::post('/orders/addPromo/{order}', [OrderController::class, 'addPromo'])->name('orders.addPromo');
                Route::post('/orders/cancel/{order}', [OrderController::class, 'cancel'])->name('orders.cancel');
                Route::post('/orders/checkout/{order}', [OrderController::class, 'checkout'])->name('orders.checkout');
                Route::post('/orders/send/{order}', [OrderController::class, 'sendOrder'])->name('orders.sendOrder');

                Route::get('/payment-methods', [PaymentMethodController::class, 'getPaymentMethods'])->name('get.payment.methods');

                Route::get('/favorite-products', [ProductController::class, 'getFavotireProducts'])->name('get.favorite.products');
            });
        });
});
