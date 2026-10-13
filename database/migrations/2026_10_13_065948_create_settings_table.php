
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('settings')) {
            Schema::create('settings', function (Blueprint $table) {
                $table->id();
                $table->string('store_name')->default('Fashion Hub');
                $table->string('store_email')->nullable();
                $table->string('store_phone')->nullable();
                $table->text('store_address')->nullable();
                $table->string('currency', 10)->default('PKR');
                $table->string('timezone')->default('Asia/Karachi');
                $table->boolean('notify_new_orders')->default(true);
                $table->boolean('notify_low_stock')->default(true);
                $table->boolean('notify_new_customers')->default(false);
                $table->timestamps();
            });

            return;
        }

        $columns = [
            'store_name' => !Schema::hasColumn('settings', 'store_name'),
            'store_email' => !Schema::hasColumn('settings', 'store_email'),
            'store_phone' => !Schema::hasColumn('settings', 'store_phone'),
            'store_address' => !Schema::hasColumn('settings', 'store_address'),
            'currency' => !Schema::hasColumn('settings', 'currency'),
            'timezone' => !Schema::hasColumn('settings', 'timezone'),
            'notify_new_orders' => !Schema::hasColumn('settings', 'notify_new_orders'),
            'notify_low_stock' => !Schema::hasColumn('settings', 'notify_low_stock'),
            'notify_new_customers' => !Schema::hasColumn('settings', 'notify_new_customers'),
        ];

        Schema::table('settings', function (Blueprint $table) use ($columns) {
            if ($columns['store_name']) {
                $table->string('store_name')->default('Fashion Hub');
            }

            if ($columns['store_email']) {
                $table->string('store_email')->nullable();
            }

            if ($columns['store_phone']) {
                $table->string('store_phone')->nullable();
            }

            if ($columns['store_address']) {
                $table->text('store_address')->nullable();
            }

            if ($columns['currency']) {
                $table->string('currency', 10)->default('PKR');
            }

            if ($columns['timezone']) {
                $table->string('timezone')->default('Asia/Karachi');
            }

            if ($columns['notify_new_orders']) {
                $table->boolean('notify_new_orders')->default(true);
            }

            if ($columns['notify_low_stock']) {
                $table->boolean('notify_low_stock')->default(true);
            }

            if ($columns['notify_new_customers']) {
                $table->boolean('notify_new_customers')->default(false);
            }
        });
    }

    public function down(): void {}
};
