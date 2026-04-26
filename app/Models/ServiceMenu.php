<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceMenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'title_en',
        'title_ja',
        'description_en',
        'description_ja',
        'title',
        'description',
        'duration',
        'price',
        'poster_image',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'service_menu_id');
    }
}
