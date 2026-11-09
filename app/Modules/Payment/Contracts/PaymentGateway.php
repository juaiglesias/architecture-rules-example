<?php

namespace App\Modules\Payment\Contracts;

interface PaymentGateway
{
    /**
     * Charge the amount (in cents) and return the payment reference.
     */
    public function charge(int $orderId, int $amount): string;
}
