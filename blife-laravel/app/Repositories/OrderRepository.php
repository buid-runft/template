<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Collection;

class OrderRepository
{
    public function getAll(array $filters = []): Collection
    {
        $query = Order::query();

        if (isset($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['payment_status'])) {
            $query->where('payment_status', $filters['payment_status']);
        }

        return $query->with(['items.product', 'payment', 'user', 'shippingAddress'])->get();
    }

    public function find(int $id): ?Order
    {
        return Order::with(['items.product', 'payment', 'user', 'shippingAddress'])->find($id);
    }

    public function createOrder(array $data): Order
    {
        $order = Order::create([
            'user_id' => $data['user_id'],
            'total' => $data['total'],
            'status' => $data['status'] ?? 'pending',
            'payment_status' => $data['payment_status'] ?? 'pending',
            'shipping_address_id' => $data['shipping_address_id'] ?? null,
        ]);

        // Create order items
        if (isset($data['items'])) {
            foreach ($data['items'] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_variant_id' => $item['product_variant_id'] ?? null,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }
        }

        return $order->load(['items.product', 'payment']);
    }

    public function update(int $id, array $data): bool
    {
        $order = $this->find($id);
        return $order ? $order->update($data) : false;
    }

    public function delete(int $id): bool
    {
        $order = $this->find($id);
        return $order ? $order->delete() : false;
    }

    public function getByUser(int $userId): Collection
    {
        return Order::where('user_id', $userId)->with(['items.product', 'payment'])->get();
    }
}
