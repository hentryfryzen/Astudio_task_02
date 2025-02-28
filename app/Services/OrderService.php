<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderHistory;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function generateOrderNumber()
    {
        $lastOrder = Order::latest()->first();
        $number = $lastOrder ? (int) explode('-', $lastOrder->order_number)[1] + 1 : 1;
        return 'ORD-' . str_pad($number, 6, '0', STR_PAD_LEFT);
    }

    public function createOrder(array $data)
    {
        return DB::transaction(function () use ($data) {
            $orderNumber = $this->generateOrderNumber();
            $order = Order::create([
                'order_number' => $orderNumber,
                'total_amount' => 0,
                'status' => 'pending',
            ]);

            $totalAmount = 0;
            foreach ($data['items'] as $item) {
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_name' => $item['product_name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
                $totalAmount += $item['quantity'] * $item['price'];
            }

            $order->update(['total_amount' => $totalAmount]);

            OrderHistory::create([
                'order_id' => $order->id,
                'status' => 'pending',
                'changed_by' => 'system',
            ]);

            return $order;
        });
    }

    public function approveOrder(Order $order, string $changedBy)
    {
        if ($order->status !== 'pending') {
            throw new \Exception('Order cannot be approved.');
        }

        $order->update(['status' => 'approved']);

        OrderHistory::create([
            'order_id' => $order->id,
            'status' => 'approved',
            'changed_by' => $changedBy,
        ]);
    }
}
