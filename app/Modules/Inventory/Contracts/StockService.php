<?php

namespace App\Modules\Inventory\Contracts;

interface StockService
{
    /**
     * Unit price in cents, or null when the product does not exist.
     */
    public function priceOf(string $sku): ?int;

    /**
     * Decrement the stock of the product. Returns false when there is not enough stock.
     */
    public function reserve(string $sku, int $quantity): bool;
}
