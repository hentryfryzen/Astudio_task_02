<?php


namespace Tests\Feature;

use App\Models\Order;
use Tests\TestCase;

class OrderTest extends TestCase
{
    public function test_create_order()
    {
        $response = $this->postJson('/api/orders', [
            'items' => [
                ['product_name' => 'Product A', 'quantity' => 2, 'price' => 100],
            ],
        ]);

        $response->assertStatus(201);
    }
}
