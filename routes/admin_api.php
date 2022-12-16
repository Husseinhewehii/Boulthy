<?php

use App\Http\Controllers\Api\Admin\ActivityLogController;
use App\Http\Controllers\Api\Admin\AddressController;
use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Admin\BlogController;
use App\Http\Controllers\Api\Admin\CategoryController;
use App\Http\Controllers\Api\Admin\CityController;
use App\Http\Controllers\Api\Admin\CommentController;
use App\Http\Controllers\Api\Admin\CommissionController;
use App\Http\Controllers\Api\Admin\DiscountController;
use App\Http\Controllers\Api\Admin\DistrictController;
use App\Http\Controllers\Api\Admin\FaqController;
use App\Http\Controllers\Api\Admin\JobApplicationController;
use App\Http\Controllers\Api\Admin\MediaController;
use App\Http\Controllers\Api\Admin\OrderController;
use App\Http\Controllers\Api\Admin\PartnerController;
use App\Http\Controllers\Api\Admin\PermissionController;
use App\Http\Controllers\Api\Admin\StaticContentController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Admin\ProductController;
use App\Http\Controllers\Api\Admin\PromoController;
use App\Http\Controllers\Api\Admin\RoleController;
use App\Http\Controllers\Api\Admin\SettingController;
use App\Http\Controllers\Api\Admin\TagController;
use App\Http\Controllers\Api\Admin\TransactionController;
use App\Http\Controllers\Api\Admin\VacancyController;
use App\Http\Controllers\Api\Admin\WalletController;

use App\Http\Controllers\Api\Admin\PageHeaderController;
use App\Http\Controllers\Api\Admin\PartitionController;
use App\Http\Controllers\Api\Admin\SliderController;

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


Route::group([
    'prefix' => LaravelLocalization::setLocale()
    ], function(){

        Route::prefix('/admin')->name('admin.')->group(function(){
            Route::post('/login', [AuthController::class, 'login'])->name('login');
            Route::middleware('auth:api', 'admin')->group(function () {
                Route::get('/test', function(){ echo "admin auth and ver";});

                Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change.password');
                Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

                Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity.log.index');
                Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');

                Route::get('/static-content', [StaticContentController::class, 'index'])->name('static.content.index');
                Route::post('/static-content', [StaticContentController::class, 'update'])->name('static.content.update');
                Route::post('/static-content-by-key', [StaticContentController::class, 'updateByKey'])->name('static.content.update.by.key');

                Route::post('/settings', [SettingController::class, 'updateSetting'])->name('setting.update');;
                Route::post('/settings-by-key', [SettingController::class, 'updateSettingsByKey'])->name('setting.update.by.key');

                Route::resource('/users', UserController::class)->only(['index', 'store', 'update', 'destroy', 'show']);
                Route::resource('/categories', CategoryController::class)->only(['index', 'store', 'update', 'destroy', 'show']);
                Route::resource('/products', ProductController::class)->only(['index', 'store', 'update', 'destroy', 'show']);
                Route::resource('/tags', TagController::class)->only(['index', 'store', 'update', 'destroy', 'show']);
                Route::resource('/roles', RoleController::class)->only(['index', 'store', 'update', 'destroy', 'show']);
                Route::resource('/discounts', DiscountController::class)->only(['index', 'store', 'update', 'destroy', 'show']);
                Route::resource('/addresses', AddressController::class)->only(['index', 'store', 'update', 'destroy', 'show']);
                Route::resource('/promos', PromoController::class)->only(['index', 'store', 'update', 'destroy', 'show']);
                Route::resource('/vacancies', VacancyController::class)->only(['index', 'store', 'update', 'destroy', 'show']);
                Route::resource('/partners', PartnerController::class)->only(['index', 'store', 'update', 'destroy', 'show']);
                Route::resource('/faqs', FaqController::class)->only(['index', 'store', 'update', 'destroy', 'show']);
                Route::resource('/cities', CityController::class)->only(['index', 'store', 'update', 'destroy', 'show']);
                Route::resource('/districts', DistrictController::class)->only(['index', 'store', 'update', 'destroy', 'show']);

                Route::resource('/job-applications', JobApplicationController::class)->only(['index', 'show']);
                Route::resource('/transactions', TransactionController::class)->only(['index', 'show']);
                Route::resource('/wallets', WalletController::class)->only(['index', 'show']);
                Route::resource('/commissions', CommissionController::class)->only(['index', 'show']);

                Route::resource('/blogs', BlogController::class)->only(['index', 'store', 'update', 'destroy', 'show']);
                Route::post('/blogs/{blog}/comments', [BlogController::class, 'comment'])->name('blogs.comments.index');

                Route::resource('/comments', CommentController::class)->only(['update', 'destroy']);

                Route::delete('/media/{media}', [MediaController::class, 'destroy']);
                Route::resource('/orders', OrderController::class)->only(['index', 'show']);
                Route::post('/orders/ship/{order}', [OrderController::class, 'ship'])->name('orders.ship');
                Route::post('/orders/finalize/{order}', [OrderController::class, 'finalize'])->name('orders.finalize');

                Route::get('/carts/manage', [OrderController::class, 'manage']);

                Route::resource('partitions', PartitionController::class)->only('update', 'index', 'show');
                Route::resource('pageHeaders', PageHeaderController::class)->only('update', 'index', 'show');
                Route::resource('sliders', SliderController::class)->only('store', 'index', 'destroy');
            });
        });
});





