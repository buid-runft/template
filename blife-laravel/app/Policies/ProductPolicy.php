<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Product;

class ProductPolicy
{
    public function view(User $user, Product $product)
    {
        return $user->role === 'admin' || $product->seller_id === $user->id || $user->role === 'customer';
    }

    public function create(User $user)
    {
        return in_array($user->role, ['vendor', 'admin']);
    }

    public function update(User $user, Product $product)
    {
        return $user->role === 'admin' || $product->seller_id === $user->id;
    }

    public function delete(User $user, Product $product)
    {
        return $user->role === 'admin' || $product->seller_id === $user->id;
    }
}
