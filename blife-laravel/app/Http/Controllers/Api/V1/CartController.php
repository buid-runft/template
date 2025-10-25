<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Services\Cart\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(
        protected CartService $cartService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $cart = $request->user()->cart ?? $this->cartService->getOrCreateCart($request->user());

        return response()->json(new CartResource($cart->load('items.product.variants')));
    }

    public function addItem(\App\Http\Requests\AddToCartRequest $request): JsonResponse
    {
        $cart = $this->cartService->addItem($request->user(), $request->validated());

        return response()->json([
            'message' => 'เพิ่มสินค้าในตะกร้าเรียบร้อยแล้ว',
            'cart' => new CartResource($cart->load('items.product.variants')),
        ]);
    }

    public function updateItem($itemId, \App\Http\Requests\UpdateCartItemRequest $request): JsonResponse
    {
        $cart = $this->cartService->updateItem($request->user(), $itemId, $request->validated());

        return response()->json([
            'message' => 'อัปเดตจำนวนสินค้าเรียบร้อยแล้ว',
            'cart' => new CartResource($cart->load('items.product.variants')),
        ]);
    }

    public function removeItem($itemId): JsonResponse
    {
        $cart = $this->cartService->removeItem($request->user(), $itemId);

        return response()->json([
            'message' => 'ลบสินค้าออกจากตะกร้าเรียบร้อยแล้ว',
            'cart' => new CartResource($cart->load('items.product.variants')),
        ]);
    }

    public function clear(): JsonResponse
    {
        $this->cartService->clearCart($request->user());

        return response()->json(['message' => 'ล้างตะกร้าสินค้าเรียบร้อยแล้ว']);
    }
}