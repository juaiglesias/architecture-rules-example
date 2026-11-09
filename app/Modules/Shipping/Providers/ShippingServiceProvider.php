<?php

namespace App\Modules\Shipping\Providers;

use App\Modules\Shipping\Contracts\ShippingService;
use App\Modules\Shipping\Services\EloquentShippingService;
use Illuminate\Support\ServiceProvider;

class ShippingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ShippingService::class, EloquentShippingService::class);
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
    }
}
