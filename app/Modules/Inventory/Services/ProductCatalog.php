<?php

namespace App\Modules\Inventory\Services;

use App\Modules\Inventory\Models\Product;
use Illuminate\Support\Collection;

class ProductCatalog
{
    public function all(): Collection
    {
        return Product::orderBy('sku')->get();
    }
}
