<?php

namespace App\Modules\Inventory\Services;

use App\Modules\Inventory\Contracts\StockService;
use App\Modules\Inventory\Models\Product;

class EloquentStockService implements StockService
{
    public function priceOf(string $sku): ?int
    {
        return Product::where('sku', $sku)->value('price');
    }

    public function reserve(string $sku, int $quantity): bool
    {
        return Product::where('sku', $sku)
            ->where('stock', '>=', $quantity)
            ->decrement('stock', $quantity) > 0;
    }
}
