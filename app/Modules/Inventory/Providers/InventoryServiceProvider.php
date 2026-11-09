<?php

namespace App\Modules\Inventory\Providers;

use App\Modules\Inventory\Contracts\StockService;
use App\Modules\Inventory\Services\EloquentStockService;
use Illuminate\Support\ServiceProvider;

class InventoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(StockService::class, EloquentStockService::class);
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
    }
}
