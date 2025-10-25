<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HealthCheckController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Health check endpoint สำหรับตรวจสอบสถานะระบบ
Route::get('/health', [HealthCheckController::class, 'check']);

// Monitoring endpoints สำหรับตรวจสอบระบบ
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/monitoring/dashboard', [\App\Http\Controllers\MonitoringController::class, 'dashboard']);
});

// API Version 1
Route::prefix('v1')->group(function () {
    // Public routes
    Route::get('/products', [\App\Http\Controllers\Api\V1\ProductController::class, 'index']);
    Route::get('/products/{slug}', [\App\Http\Controllers\Api\V1\ProductController::class, 'show']);
    Route::get('/categories', [\App\Http\Controllers\Api\V1\CategoryController::class, 'index']);
    Route::get('/categories/{slug}', [\App\Http\Controllers\Api\V1\CategoryController::class, 'show']);
    Route::get('/categories/{slug}/products', [\App\Http\Controllers\Api\V1\CategoryController::class, 'products']);
    Route::get('/stores/{slug}', [\App\Http\Controllers\Api\V1\StoreController::class, 'show']);

    // Protected routes (require authentication)
    Route::middleware('auth:sanctum')->group(function () {
        // User routes
        Route::get('/user/profile', [\App\Http\Controllers\Api\V1\UserController::class, 'profile']);
        Route::put('/user/profile', [\App\Http\Controllers\Api\V1\UserController::class, 'updateProfile']);

        // Store routes
        Route::post('/stores/onboard', [\App\Http\Controllers\Api\V1\StoreController::class, 'onboard']);
        Route::get('/stores/my', [\App\Http\Controllers\Api\V1\StoreController::class, 'myStore']);

        // Product management (for sellers)
        Route::get('/products/my', [\App\Http\Controllers\Api\V1\ProductController::class, 'myProducts']);
        Route::post('/products', [\App\Http\Controllers\Api\V1\ProductController::class, 'store']);
        Route::put('/products/{id}', [\App\Http\Controllers\Api\V1\ProductController::class, 'update']);
        Route::delete('/products/{id}', [\App\Http\Controllers\Api\V1\ProductController::class, 'destroy']);

        // Order routes
        Route::get('/orders', [\App\Http\Controllers\Api\V1\OrderController::class, 'index']);
        Route::get('/orders/{id}', [\App\Http\Controllers\Api\V1\OrderController::class, 'show']);
        Route::post('/orders', [\App\Http\Controllers\Api\V1\OrderController::class, 'store']);
        Route::put('/orders/{id}/cancel', [\App\Http\Controllers\Api\V1\OrderController::class, 'cancel']);
        Route::get('/orders/{id}/track', [\App\Http\Controllers\Api\V1\OrderController::class, 'track']);

        // Cart routes
        Route::get('/cart', [\App\Http\Controllers\Api\V1\CartController::class, 'index']);
        Route::post('/cart/items', [\App\Http\Controllers\Api\V1\CartController::class, 'addItem']);
        Route::put('/cart/items/{itemId}', [\App\Http\Controllers\Api\V1\CartController::class, 'updateItem']);
        Route::delete('/cart/items/{itemId}', [\App\Http\Controllers\Api\V1\CartController::class, 'removeItem']);
        Route::delete('/cart', [\App\Http\Controllers\Api\V1\CartController::class, 'clear']);
    });
});
