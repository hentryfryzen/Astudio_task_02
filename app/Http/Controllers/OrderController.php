<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_name' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        $order = $this->orderService->createOrder($request->all());
        return response()->json($order, 201);
    }

    public function show(Order $order)
    {
        return response()->json($order->load('items', 'history'));
    }

    public function approve(Order $order, Request $request)
    {
        $request->validate(['changed_by' => 'required|string']);

        $this->orderService->approveOrder($order, $request->changed_by);
        return response()->json($order);
    }
}
