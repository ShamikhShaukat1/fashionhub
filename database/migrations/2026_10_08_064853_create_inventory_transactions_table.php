<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventory_transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->enum('type', [
                'stock_in',
                'stock_out',
                'adjustment',
                'return'
            ]);

            /*
             * Positive = stock added
             * Negative = stock removed
             */
            $table->integer('quantity_change');

            $table->unsignedInteger('stock_before');
            $table->unsignedInteger('stock_after');

            $table->string('reason')->nullable();

            $table->string('reference_type')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index([
                'reference_type',
                'reference_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_transactions');
    }
};
