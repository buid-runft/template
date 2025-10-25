<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository
{
    public function getAll(array $filters = []): Collection
    {
        $query = Product::query();

        if (isset($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (isset($filters['vendor_id'])) {
            $query->where('vendor_id', $filters['vendor_id']);
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->with(['variants', 'category', 'vendor'])->get();
    }

    public function find(int $id): ?Product
    {
        return Product::with(['variants', 'category', 'vendor'])->find($id);
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $product = $this->find($id);
        return $product ? $product->update($data) : false;
    }

    public function delete(int $id): bool
    {
        $product = $this->find($id);
        return $product ? $product->delete() : false;
    }
}
