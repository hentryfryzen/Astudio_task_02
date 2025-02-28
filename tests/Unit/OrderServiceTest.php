<?php

namespace Tests\Unit;

use App\Services\OrderService;
use App\Models\Order;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    public function test_order_number_generation()
    {
        $service = new OrderService();
        $number1 = $service->generateOrderNumber();
        $number2 = $service->generateOrderNumber();

        $this->assertNotEquals($number1, $number2);
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
