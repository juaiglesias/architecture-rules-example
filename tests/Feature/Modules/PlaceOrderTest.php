<?php

namespace Tests\Feature\Modules;

use App\Modules\Inventory\Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlaceOrderTest extends TestCase
{
    use RefreshDatabase;

    protected $seeder = ProductSeeder::class;

    public function test_it_places_an_order_across_all_modules(): void
    {
        $response = $this->postJson('/api/orders', [
            'sku' => 'MONITOR',
            'quantity' => 2,
            'address' => 'Av. Siempre Viva 742',
        ]);

        $response->assertCreated()->assertJson(['status' => 'placed', 'total' => 70000]);

        $this->assertDatabaseHas('products', ['sku' => 'MONITOR', 'stock' => 1]);
        $this->assertDatabaseHas('payments', ['order_id' => $response->json('id'), 'amount' => 70000]);
        $this->assertDatabaseHas('shipments', ['order_id' => $response->json('id')]);

        $this->getJson('/api/orders/'.$response->json('id'))->assertOk()->assertJson(['sku' => 'MONITOR']);
    }

    public function test_it_rejects_orders_without_stock(): void
    {
        $this->postJson('/api/orders', ['sku' => 'MONITOR', 'quantity' => 4, 'address' => 'Somewhere'])
            ->assertUnprocessable();

        $this->assertDatabaseHas('products', ['sku' => 'MONITOR', 'stock' => 3]);
        $this->assertDatabaseCount('orders', 0);
    }
}
