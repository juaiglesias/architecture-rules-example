<?php

namespace App\Modules\Payment\Services;

use App\Modules\Payment\Contracts\PaymentGateway;
use App\Modules\Payment\Models\Payment;
use Illuminate\Support\Str;

class FakePaymentGateway implements PaymentGateway
{
    public function charge(int $orderId, int $amount): string
    {
        return Payment::create([
            'order_id' => $orderId,
            'amount' => $amount,
            'reference' => 'PAY-'.Str::upper(Str::random(10)),
            'status' => 'paid',
        ])->reference;
    }
}
