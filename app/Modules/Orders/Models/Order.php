<?php

namespace App\Modules\Orders\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['sku', 'quantity', 'total', 'address', 'status', 'payment_reference', 'tracking_number'])]
class Order extends Model {}
