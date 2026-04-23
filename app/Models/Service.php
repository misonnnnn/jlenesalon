<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en',
        'name_ja',
        'slug',
        'excerpt',
        'icon_image',
        'excerpt_image',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function menus(): HasMany
    {
        return $this->hasMany(ServiceMenu::class)->orderBy('sort_order');
    }
}
