<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Services\Order\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        protected OrderService $orderService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $orders = $request->user()->orders()
            ->with(['items.product', 'store', 'payment'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->paginate(20);

        return response()->json(OrderResource::collection($orders));
    }

    public function show($id): JsonResponse
    {
        $order = $request->user()->orders()
            ->with(['items.product', 'store', 'payment', 'shippingAddress'])
            ->findOrFail($id);

        return response()->json(new OrderResource($order));
    }

    public function store(\App\Http\Requests\CreateOrderRequest $request): JsonResponse
    {
        $order = $this->orderService->createOrder($request->user(), $request->validated());

        return response()->json([
            'message' => 'สั่งซื้อเรียบร้อยแล้ว',
            'order' => new OrderResource($order->load(['items.product', 'store', 'payment'])),
        ], 201);
    }

    public function cancel($id): JsonResponse
    {
        $order = $request->user()->orders()->findOrFail($id);
        $this->orderService->cancelOrder($order);

        return response()->json(['message' => 'ยกเลิกคำสั่งซื้อเรียบร้อยแล้ว']);
    }

    public function track($id): JsonResponse
    {
        $order = $request->user()->orders()->findOrFail($id);

        return response()->json([
            'order_id' => $order->id,
            'status' => $order->status,
            'tracking_number' => $order->tracking_number,
            'estimated_delivery' => $order->estimated_delivery,
        ]);
    }
}
