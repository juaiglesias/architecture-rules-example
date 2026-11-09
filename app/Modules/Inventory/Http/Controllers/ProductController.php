<?php

namespace App\Modules\Inventory\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Inventory\Services\ProductCatalog;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function index(ProductCatalog $catalog): JsonResponse
    {
        return response()->json($catalog->all());
    }
}
