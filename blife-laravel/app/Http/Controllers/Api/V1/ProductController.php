<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Services\Product\ProductCreationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        protected ProductCreationService $productService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $query = \App\Models\Product::with(['store', 'category', 'variants', 'reviews'])
            ->where('status', 'approved');

        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('store')) {
            $query->where('store_id', $request->store);
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(20);

        return response()->json(ProductResource::collection($products));
    }

    public function show($slug): JsonResponse
    {
        $product = \App\Models\Product::where('slug', $slug)
            ->where('status', 'approved')
            ->with(['store', 'category', 'variants', 'reviews', 'snowballSettings'])
            ->firstOrFail();

        return response()->json(new ProductResource($product));
    }

    public function store(\App\Http\Requests\CreateProductRequest $request): JsonResponse
    {
        $product = $this->productService->createProduct($request->user(), $request->validated());

        return response()->json([
            'message' => 'สินค้าถูกสร้างเรียบร้อย รอการอนุมัติจากแอดมิน',
            'product' => new ProductResource($product->load('variants')),
        ], 201);
    }

    public function myProducts(Request $request): JsonResponse
    {
        $products = $request->user()->store->products()
            ->with(['category', 'variants', 'reviews'])
            ->paginate(20);

        return response()->json(ProductResource::collection($products));
    }

    public function update($id, \App\Http\Requests\UpdateProductRequest $request): JsonResponse
    {
        $product = $request->user()->store->products()->findOrFail($id);
        $product = $this->productService->updateProduct($product, $request->validated());

        return response()->json(new ProductResource($product->load('variants')));
    }

    public function destroy($id): JsonResponse
    {
        $product = auth()->user()->store->products()->findOrFail($id);
        $product->delete();

        return response()->json(['message' => 'ลบสินค้าเรียบร้อยแล้ว']);
    }
}
