<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Payment;

class PaymentPolicy
{
    public function view(User $user, Payment $payment)
    {
        if ($user->role === 'admin') return true;
        return $user->id === $payment->user_id;
    }

    public function create(User $user)
    {
        return $user->role === 'customer';
    }

    public function update(User $user, Payment $payment)
    {
        return $user->role === 'admin';
    }
}
php artisan make:provider AuthServiceProvider