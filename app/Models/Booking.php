<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'service_menu_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'starts_at',
        'notes',
        'status',
        'payment_method',
        'payment_status',
        'stripe_amount_total',
        'stripe_currency',
        'stripe_refund_id',
        'stripe_refunded_amount',
        'stripe_refunded_at',
        'stripe_checkout_session_id',
        'stripe_payment_intent_id',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'stripe_refunded_at' => 'datetime',
    ];

    public function menu(): BelongsTo
    {
        return $this->belongsTo(ServiceMenu::class, 'service_menu_id');
    }
}
