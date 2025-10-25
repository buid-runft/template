<?php

namespace App\Services\Snowball;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\SnowballPlan;

class SnowballCalculator
{
    public function calculateForOrder(Order $order): float
    {
        $totalPoints = 0;

        foreach ($order->items as $item) {
            $points = $this->calculateForItem($item);
            $totalPoints += $points;
        }

        return $totalPoints;
    }

    public function calculateForItem(OrderItem $item): float
    {
        $product = $item->product;
        $setting = $product->snowballSetting;

        if (!$setting) {
            return 0; // ไม่มี snowball setting → ไม่ได้ points
        }

        $plan = SnowballPlan::where('plan_type', $setting->snowball_plan_type)->first();

        if (!$plan || !$plan->is_active) {
            return 0;
        }

        if ($setting->use_custom_calculation && $setting->fixed_points_per_unit) {
            // ใช้ค่าคงที่
            $points = $item->quantity * $setting->fixed_points_per_unit;
        } else {
            // ใช้สูตรจาก plan
            $multiplier = $setting->custom_multiplier ?? $plan->base_multiplier;
            $points = $item->total * $multiplier;
        }

        // จำกัดค่าสูงสุด
        if ($setting->max_points_per_product) {
            $points = min($points, $setting->max_points_per_product);
        }

        return round($points, 2);
    }
}
