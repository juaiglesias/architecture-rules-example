<?php

namespace App\Modules\Orders\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Orders\Services\OrderService;
use DomainException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(private OrderService $orders) {}

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'sku' => ['required', 'string'],
            'quantity' => ['required', 'integer', 'min:1'],
            'address' => ['required', 'string'],
        ]);

        try {
            $order = $this->orders->place($data['sku'], $data['quantity'], $data['address']);
        } catch (DomainException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json($order, 201);
    }

    public function show(int $id): JsonResponse
    {
        $order = $this->orders->find($id);

        abort_if($order === null, 404);

        return response()->json($order);
    }
}
