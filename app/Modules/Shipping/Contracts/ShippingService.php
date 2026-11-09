<?php

namespace App\Modules\Shipping\Contracts;

interface ShippingService
{
    /**
     * Schedule the shipment and return its tracking number.
     */
    public function schedule(int $orderId, string $address): string;
}
