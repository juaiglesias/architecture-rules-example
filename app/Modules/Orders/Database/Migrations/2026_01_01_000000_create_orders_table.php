<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('sku');
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('total');
            $table->string('address');
            $table->string('status');
            $table->string('payment_reference')->nullable();
            $table->string('tracking_number')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
