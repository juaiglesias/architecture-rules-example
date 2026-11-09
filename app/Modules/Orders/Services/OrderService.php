<?php

namespace App\Modules\Orders\Services;

use App\Modules\Inventory\Contracts\StockService;
use App\Modules\Orders\Models\Order;
use App\Modules\Payment\Contracts\PaymentGateway;
use App\Modules\Shipping\Contracts\ShippingService;
use DomainException;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function __construct(
        private StockService $stock,
        private PaymentGateway $payments,
        private ShippingService $shipping,
    ) {}

    public function find(int $id): ?Order
    {
        return Order::find($id);
    }

    /**
     * @throws DomainException when the product does not exist or is out of stock.
     */
    public function place(string $sku, int $quantity, string $address): Order
    {
        return DB::transaction(function () use ($sku, $quantity, $address) {
            $price = $this->stock->priceOf($sku) ?? throw new DomainException("Unknown product [$sku].");

            if (! $this->stock->reserve($sku, $quantity)) {
                throw new DomainException("Not enough stock for [$sku].");
            }

            $order = Order::create([
                'sku' => $sku,
                'quantity' => $quantity,
                'total' => $price * $quantity,
                'address' => $address,
                'status' => 'pending',
            ]);

            $order->update([
                'payment_reference' => $this->payments->charge($order->id, $order->total),
                'tracking_number' => $this->shipping->schedule($order->id, $address),
                'status' => 'placed',
            ]);

            return $order;
        });
    }
}
