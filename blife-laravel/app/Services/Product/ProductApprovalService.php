<?php

namespace App\Services\Product;

use App\Models\Product;

class ProductApprovalService
{
    public function approveProduct(Product $product): void
    {
        $product->update([
            'is_approved' => true,
            'is_active' => true,
        ]);

        event(new \App\Events\ProductApproved($product));
    }

    public function rejectProduct(Product $product, string $reason = null): void
    {
        $product->update([
            'is_approved' => false,
            'is_active' => false,
            'notes' => $reason,
        ]);
    }
}
