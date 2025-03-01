<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderStatusChange;
use Illuminate\Support\Facades\DB;

class OrderService
{
    // Generate Unique Order Number
    public function generateOrderNumber(): string
    {
        $lastOrder = Order::lockForUpdate()->latest('id')->first();
        $nextNumber = optional($lastOrder)->id + 1;
        return 'ORD-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
    }

    // Create Order
    public function createOrder(array $data)
    {
        if (empty($data['items']) || count($data['items']) === 0) {
            throw new \Exception("Order must have at least one item.");
        }

        return DB::transaction(function () use ($data) {
            $orderNumber = $this->generateOrderNumber();

            $totalAmount = array_sum(array_map(function ($item) {
                return $item['price'] * $item['quantity'];
            }, $data['items']));

            $status = $totalAmount > 1000 ? 'pending' : 'approved';

            $order = Order::create([
                'order_number' => $orderNumber,
                'items' => json_encode($data['items']),
                'total_amount' => $totalAmount,
                'status' => $status,
            ]);

            return $order;
        });
    }

    // Get All Orders
    public function getAllOrders()
    {
        return Order::all();
    }

    // Get Order by ID
    public function getOrderById($id)
    {
        return Order::findOrFail($id);
    }

    // Approve Order
    public function approveOrder($id)
    {
        return DB::transaction(function () use ($id) {
            $order = Order::findOrFail($id);

            if ($order->status === 'approved') {
                throw new \Exception("Order is already approved and cannot be modified.");
            }

            $oldStatus = $order->status;
            $order->update(['status' => 'approved']);

            OrderStatusChange::create([
                'order_id' => $order->id,
                'old_status' => $oldStatus,
                'new_status' => 'approved',
            ]);

            return $order;
        });
    }

    // Delete Order
    public function deleteOrder($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status === 'approved') {
            throw new \Exception("Approved orders cannot be deleted.");
        }

        $order->delete();
    }

    // Get Order History
    public function getOrderHistory($id)
    {
        return OrderStatusChange::where('order_id', $id)->get();
    }
}
