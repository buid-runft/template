<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Database\Eloquent\Collection;

class CartRepository
{
    public function findOrCreateCart(int $userId): Cart
    {
        return Cart::firstOrCreate(['user_id' => $userId]);
    }

    public function getCartByUser(int $userId): ?Cart
    {
        return Cart::where('user_id', $userId)->with(['items.product.variants', 'user'])->first();
    }

    public function addItem(Cart $cart, int $productId, int $quantity, ?int $variantId = null): CartItem
    {
        $existingItem = $cart->items()->where('product_id', $productId)
            ->where('product_variant_id', $variantId)
            ->first();

        if ($existingItem) {
            $existingItem->increment('quantity', $quantity);
            return $existingItem;
        }

        return $cart->items()->create([
            'product_id' => $productId,
            'product_variant_id' => $variantId,
            'quantity' => $quantity,
        ]);
    }

    public function removeItem(int $cartItemId): bool
    {
        $item = CartItem::find($cartItemId);
        return $item ? $item->delete() : false;
    }

    public function updateItemQuantity(int $cartItemId, int $quantity): bool
    {
        $item = CartItem::find($cartItemId);
        if ($item) {
            $item->quantity = $quantity;
            return $item->save();
        }
        return false;
    }

    public function clearCart(int $userId): bool
    {
        $cart = $this->getCartByUser($userId);
        if ($cart) {
            return $cart->items()->delete();
        }
        return false;
    }

    public function getCartTotal(int $userId): float
    {
        $cart = $this->getCartByUser($userId);
        return $cart ? $cart->items->sum(function ($item) {
            return $item->quantity * $item->product->base_price;
        }) : 0;
    }
}
