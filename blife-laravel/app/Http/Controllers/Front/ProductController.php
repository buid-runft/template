<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['store', 'category']);

        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(12);
        $categories = Category::all();

        return view('landing-page.customer.products', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::with(['store', 'category', 'reviews.user'])->findOrFail($id);

        return view('landing-page.customer.product-detail', compact('product'));
    }

    public function category($id)
    {
        $category = Category::findOrFail($id);
        $products = Product::where('category_id', $id)->with('store')->paginate(12);

        return view('landing-page.customer.category-products', compact('category', 'products'));
    }
}
