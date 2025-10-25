<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Order;

class OrderPolicy
{
    public function view(User $user, Order $order)
    {
        if ($user->role === 'admin') return true;
        if ($user->role === 'vendor') return $order->vendor_id === $user->id;
        return $order->user_id === $user->id;
    }

    public function update(User $user, Order $order)
    {
        return $user->role === 'admin' || $order->vendor_id === $user->id;
    }

    public function cancel(User $user, Order $order)
    {
        return $user->role === 'customer' && $order->status === 'pending';
    }
}
