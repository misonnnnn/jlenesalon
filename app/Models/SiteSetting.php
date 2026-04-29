<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    public const KEY_LANGUAGE_SELECTOR_ENABLED = 'language_selector_enabled';

    protected $fillable = [
        'key',
        'value',
    ];

    public static function get(string $key, ?string $default = null): ?string
    {
        return Cache::rememberForever('site_settings.' . $key, function () use ($key, $default) {
            return self::query()
                ->where('key', $key)
                ->value('value') ?? $default;
        });
    }

    public static function put(string $key, string $value): void
    {
        self::query()->updateOrCreate([
            'key' => $key,
        ], [
            'value' => $value,
        ]);

        Cache::forget('site_settings.' . $key);
    }

    public static function getBool(string $key, bool $default = false): bool
    {
        $value = self::get($key, $default ? '1' : '0');

        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    public static function putBool(string $key, bool $value): void
    {
        self::put($key, $value ? '1' : '0');
    }

    public static function firstOrDefault(string $key, string $default): self
    {
        return self::query()->firstOrCreate([
            'key' => $key,
        ], [
            'value' => $default,
        ]);
    }

    public static function setLanguageSelectorEnabled(bool $enabled): void
    {
        self::putBool(self::KEY_LANGUAGE_SELECTOR_ENABLED, $enabled);
    }

    public static function isLanguageSelectorEnabled(): bool
    {
        return self::getBool(self::KEY_LANGUAGE_SELECTOR_ENABLED, true);
    }
}
