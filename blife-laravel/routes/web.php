<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/', function () {
    return redirect('/admin/dashboard');
});

// Admin Dashboard Routes
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/category', [DashboardController::class, 'category'])->name('admin.category');
    Route::get('/add-new-category', [DashboardController::class, 'addNewCategory'])->name('admin.add-new-category');
    Route::post('/store-category', [DashboardController::class, 'storeCategory'])->name('admin.store-category');
    Route::get('/attributes', [DashboardController::class, 'attributes'])->name('admin.attributes');
Route::get('/add-new-attributes', [DashboardController::class, 'addNewAttributes'])->name('admin.add-new-attributes');
    Route::get('/products', [DashboardController::class, 'products'])->name('admin.products');
    Route::get('/add-new-product', [DashboardController::class, 'addNewProduct'])->name('admin.add-new-product');
    Route::get('/product-review', [DashboardController::class, 'productReview'])->name('admin.product-review');
    Route::get('/order-list', [DashboardController::class, 'orderList'])->name('admin.order-list');
    Route::get('/order-detail', [DashboardController::class, 'orderDetail'])->name('admin.order-detail');
    Route::get('/create-order', [DashboardController::class, 'createOrder'])->name('admin.create-order');
    Route::get('/order-tracking', [DashboardController::class, 'orderTracking'])->name('admin.order-tracking');
    Route::get('/vendor-list', [DashboardController::class, 'vendorList'])->name('admin.vendor-list');
    Route::get('/create-vendor', [DashboardController::class, 'createVendor'])->name('admin.create-vendor');
    Route::get('/coupon-list', [DashboardController::class, 'couponList'])->name('admin.coupon-list');
    Route::get('/create-coupon', [DashboardController::class, 'createCoupon'])->name('admin.create-coupon');
    Route::get('/all-users', [DashboardController::class, 'allUsers'])->name('admin.all-users');
    Route::get('/add-new-user', [DashboardController::class, 'addNewUser'])->name('admin.add-new-user');
    Route::get('/role', [DashboardController::class, 'role'])->name('admin.role');
    Route::get('/create-role', [DashboardController::class, 'createRole'])->name('admin.create-role');
    Route::get('/reports', [DashboardController::class, 'reports'])->name('admin.reports');
    Route::get('/media', [DashboardController::class, 'media'])->name('admin.media');
    Route::get('/content-settings', [DashboardController::class, 'contentSettings'])->name('admin.content-settings');
    Route::get('/content-settings-full', [DashboardController::class, 'contentSettingsFull'])->name('admin.content-settings-full');
    Route::get('/content-settings-dynamic', [DashboardController::class, 'contentSettingsDynamic'])->name('admin.content-settings-dynamic');
    Route::get('/create-menu', [DashboardController::class, 'createMenu'])->name('admin.create-menu');
    Route::get('/menu-lists', [DashboardController::class, 'menuLists'])->name('admin.menu-lists');
    Route::get('/translation', [DashboardController::class, 'translation'])->name('admin.translation');
    Route::get('/currency-rates', [DashboardController::class, 'currencyRates'])->name('admin.currency-rates');
    Route::get('/taxes', [DashboardController::class, 'taxes'])->name('admin.taxes');
    Route::get('/support-ticket', [DashboardController::class, 'supportTicket'])->name('admin.support-ticket');
    Route::get('/backup-index', [DashboardController::class, 'backupIndex'])->name('admin.backup-index');
    Route::get('/invoice', [DashboardController::class, 'invoice'])->name('admin.invoice');
    Route::get('/list-page', [DashboardController::class, 'listPage'])->name('admin.list-page');
    Route::get('/profile-setting', [DashboardController::class, 'profileSetting'])->name('admin.profile-setting');
    Route::get('/login', [DashboardController::class, 'login'])->name('admin.login');
    Route::get('/sign-up', [DashboardController::class, 'signUp'])->name('admin.sign-up');
    Route::get('/forgot-password', [DashboardController::class, 'forgotPassword'])->name('admin.forgot-password');
    Route::get('/forgot', [DashboardController::class, 'forgot'])->name('admin.forgot');
    Route::get('/otp', [DashboardController::class, 'otp'])->name('admin.otp');
});


