<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureStoreOnboarded
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // ถ้าเป็น member ของ MLM แต่ยังไม่มีร้าน
            if ($user->mlm_member_code && !$user->store) {
                if (!$request->is('store/onboarding*')) {
                    return redirect()->route('store.onboarding');
                }
            }
        }

        return $next($request);
    }
}
