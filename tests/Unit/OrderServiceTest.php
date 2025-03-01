<?php

namespace Tests\Unit;

use App\Services\OrderService;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    use RefreshDatabase; // Reset the database between tests

    public function test_order_number_generation()
    {
        Order::create([
            'order_number' => 'ORD-000001',
            'total_amount' => 100,
            'status' => 'pending',
        ]);

        $service = new OrderService();

        $expectedNumber1 = 'ORD-000002';
        $expectedNumber2 = 'ORD-000003';

        $number1 = $service->generateOrderNumber();
        $this->assertEquals($expectedNumber1, $number1);

        Order::create([
            'order_number' => $number1,
            'total_amount' => 200,
            'status' => 'pending',
        ]);

        $number2 = $service->generateOrderNumber();
        $this->assertEquals($expectedNumber2, $number2);
    }


    public function test_order_creation()
    {
        $service = new OrderService();
        $order = $service->createOrder([
            'items' => [
                ['product_name' => 'Product A', 'quantity' => 2, 'price' => 100],
            ],
        ]);

        $this->assertEquals(200, $order->total_amount);
    }
}
