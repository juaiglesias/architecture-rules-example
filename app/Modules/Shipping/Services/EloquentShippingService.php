<?php

namespace App\Modules\Shipping\Services;

use App\Modules\Shipping\Contracts\ShippingService;
use App\Modules\Shipping\Models\Shipment;
use Illuminate\Support\Str;

class EloquentShippingService implements ShippingService
{
    public function schedule(int $orderId, string $address): string
    {
        return Shipment::create([
            'order_id' => $orderId,
            'address' => $address,
            'tracking_number' => 'TRK-'.Str::upper(Str::random(10)),
            'status' => 'scheduled',
        ])->tracking_number;
    }
}
