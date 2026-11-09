<?php

namespace App\Modules\Shipping\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['order_id', 'address', 'tracking_number', 'status'])]
class Shipment extends Model {}
