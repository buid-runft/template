<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = \App\Models\Category::query();

        if ($request->has('parent_id')) {
            $query->where('parent_id', $request->parent_id);
        } else {
            $query->whereNull('parent_id');
        }

        $categories = $query->with('children')->get();

        return response()->json(CategoryResource::collection($categories));
    }

    public function show($slug): JsonResponse
    {
        $category = \App\Models\Category::where('slug', $slug)
            ->with(['children', 'products' => function($query) {
                $query->where('status', 'approved')->limit(20);
            }])
            ->firstOrFail();

        return response()->json(new CategoryResource($category));
    }

    public function products($slug, Request $request): JsonResponse
    {
        $category = \App\Models\Category::where('slug', $slug)->firstOrFail();

        $products = $category->products()
            ->where('status', 'approved')
            ->with(['store', 'variants', 'reviews'])
            ->when($request->search, fn($q) => $q->where('name', 'like', '%' . $request->search . '%'))
            ->paginate(20);

        return response()->json(\App\Http\Resources\ProductResource::collection($products));
    }
}
