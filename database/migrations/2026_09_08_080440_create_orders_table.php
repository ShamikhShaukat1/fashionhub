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

            // Customer
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            // Order identification
            $table->string('order_number')->unique();

            // Order status
            $table->enum('status', [
                'pending',
                'confirmed',
                'processing',
                'shipped',
                'delivered',
                'cancelled',
            ])->default('pending');

            // Payment
            $table->enum('payment_status', [
                'pending',
                'paid',
                'failed',
                'refunded',
            ])->default('pending');

            $table->string('payment_method')->nullable();

            // Amounts
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('shipping_amount', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);

            // Shipping information
            $table->string('shipping_name');
            $table->string('shipping_email');
            $table->string('shipping_phone');

            $table->text('shipping_address');
            $table->string('shipping_city');
            $table->string('shipping_postal_code')->nullable();

            // Additional information
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
