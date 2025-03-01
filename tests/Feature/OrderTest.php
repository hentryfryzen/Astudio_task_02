<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase; // Refresh the database between tests

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
