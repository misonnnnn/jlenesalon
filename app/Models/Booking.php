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
    ];

    protected $casts = [
        'starts_at' => 'datetime',
    ];

    public function menu(): BelongsTo
    {
        return $this->belongsTo(ServiceMenu::class, 'service_menu_id');
    }
}
