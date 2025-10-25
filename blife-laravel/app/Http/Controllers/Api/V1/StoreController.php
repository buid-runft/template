<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\StoreResource;
use App\Services\Store\StoreOnboardingService;
use Illuminate\Http\JsonResponse;

class StoreController extends Controller
{
    public function __construct(
        protected StoreOnboardingService $onboardingService
    ) {}

    public function onboard(\App\Http\Requests\OnboardStoreRequest $request): JsonResponse
    {
        $store = $this->onboardingService->createStoreForUser($request->user(), $request->validated());

        return response()->json([
            'message' => 'เปิดร้านสำเร็จ รอการยืนยันจากแอดมิน',
            'store' => new StoreResource($store->load('profile', 'verification')),
        ], 201);
    }

    public function myStore(): JsonResponse
    {
        $store = auth()->user()->store;
        if (!$store) {
            return response()->json(['error' => 'คุณยังไม่มีร้านค้า'], 404);
        }

        return response()->json(new StoreResource($store->load('profile', 'settings', 'verification')));
    }

    public function show($slug): JsonResponse
    {
        $store = \App\Models\Store::where('store_slug', $slug)
            ->where('status', 'approved')
            ->firstOrFail();

        return response()->json(new StoreResource($store->load('profile', 'products')));
    }
}
