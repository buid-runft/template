<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Services\Product\ProductCreationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    protected $productCreationService;

    public function __construct(ProductCreationService $productCreationService)
    {
        $this->productCreationService = $productCreationService;
    }

    public function index()
    {
        $user = Auth::user();
        $store = $user->store;

        $products = Product::where('store_id', $store->id)->with('category')->paginate(10);

        return view('dashbord-vendor.product-list', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('dashbord-vendor.add-new-product', compact('categories'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $store = $user->store;

        $product = $this->productCreationService->createProduct($request->all(), $store);

        return redirect()->route('seller.products.index')->with('success', 'Product created successfully');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();

        return view('dashbord-vendor.edit-product', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());

        return redirect()->route('seller.products.index')->with('success', 'Product updated successfully');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('seller.products.index')->with('success', 'Product deleted successfully');
    }
}
