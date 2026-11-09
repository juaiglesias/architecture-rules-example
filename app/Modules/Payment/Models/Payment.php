<?php

namespace App\Modules\Payment\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['order_id', 'amount', 'reference', 'status'])]
class Payment extends Model {}
