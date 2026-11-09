<?php

namespace App\Modules\Payment\Providers;

use App\Modules\Payment\Contracts\PaymentGateway;
use App\Modules\Payment\Services\FakePaymentGateway;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PaymentGateway::class, FakePaymentGateway::class);
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
    }
}
