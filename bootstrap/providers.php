<?php

use App\Modules\Inventory\Providers\InventoryServiceProvider;
use App\Modules\Orders\Providers\OrdersServiceProvider;
use App\Modules\Payment\Providers\PaymentServiceProvider;
use App\Modules\Shipping\Providers\ShippingServiceProvider;
use App\Providers\AppServiceProvider;

return [
    AppServiceProvider::class,
    InventoryServiceProvider::class,
    OrdersServiceProvider::class,
    PaymentServiceProvider::class,
    ShippingServiceProvider::class,
];
