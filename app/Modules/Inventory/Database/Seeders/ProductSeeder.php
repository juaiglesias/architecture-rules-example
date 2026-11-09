<?php

namespace App\Modules\Inventory\Database\Seeders;

use App\Modules\Inventory\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['sku' => 'KEYBOARD', 'name' => 'Mechanical keyboard', 'price' => 12000, 'stock' => 10],
            ['sku' => 'MOUSE', 'name' => 'Wireless mouse', 'price' => 4500, 'stock' => 25],
            ['sku' => 'MONITOR', 'name' => '27" monitor', 'price' => 35000, 'stock' => 3],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(['sku' => $product['sku']], $product);
        }
    }
}
