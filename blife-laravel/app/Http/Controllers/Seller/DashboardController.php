<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $store = $user->store;

        if (!$store) {
            return redirect()->route('seller.onboarding');
        }

        $totalProducts = Product::where('store_id', $store->id)->count();
        $totalOrders = Order::whereHas('items.product', function ($query) use ($store) {
            $query->where('store_id', $store->id);
        })->count();

        $recentOrders = Order::whereHas('items.product', function ($query) use ($store) {
            $query->where('store_id', $store->id);
        })->with('user')->latest()->take(5)->get();

        return view('dashbord-vendor.index', compact('totalProducts', 'totalOrders', 'recentOrders'));
    }
}
