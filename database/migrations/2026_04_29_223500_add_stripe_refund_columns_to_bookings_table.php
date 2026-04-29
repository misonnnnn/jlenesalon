<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('stripe_amount_total')->nullable()->after('payment_status');
            $table->string('stripe_currency', 12)->nullable()->after('stripe_amount_total');
            $table->string('stripe_refund_id')->nullable()->after('stripe_payment_intent_id');
            $table->unsignedBigInteger('stripe_refunded_amount')->nullable()->after('stripe_refund_id');
            $table->dateTime('stripe_refunded_at')->nullable()->after('stripe_refunded_amount');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'stripe_amount_total',
                'stripe_currency',
                'stripe_refund_id',
                'stripe_refunded_amount',
                'stripe_refunded_at',
            ]);
        });
    }
};
