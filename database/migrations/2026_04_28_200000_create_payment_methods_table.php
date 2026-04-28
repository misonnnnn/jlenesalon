<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('stripe_method')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        DB::table('payment_methods')->insert([
            [
                'name' => 'Card',
                'code' => 'card',
                'stripe_method' => 'card',
                'is_active' => true,
                'sort_order' => 1,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'GCash',
                'code' => 'gcash',
                'stripe_method' => 'gcash',
                'is_active' => true,
                'sort_order' => 2,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'PayPay',
                'code' => 'paypay',
                'stripe_method' => 'paypay',
                'is_active' => true,
                'sort_order' => 3,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'LINE Pay',
                'code' => 'linepay',
                'stripe_method' => null,
                'is_active' => false,
                'sort_order' => 4,
                'notes' => 'Coming soon.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
