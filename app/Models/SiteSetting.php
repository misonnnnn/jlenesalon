<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    public const KEY_LANGUAGE_SELECTOR_ENABLED = 'language_selector_enabled';
    public const KEY_ADMIN_BOOKING_ALERT_EMAILS = 'admin_booking_alert_emails';
    public const KEY_CUSTOMER_BOOKING_EMAIL_USE_QUEUE = 'customer_booking_email_use_queue';

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

    public static function setAdminBookingAlertEmails(string $emails): void
    {
        self::put(self::KEY_ADMIN_BOOKING_ALERT_EMAILS, trim($emails));
    }

    public static function getAdminBookingAlertEmailsRaw(): string
    {
        return (string) self::get(self::KEY_ADMIN_BOOKING_ALERT_EMAILS, '');
    }

    /**
     * @return array<int, string>
     */
    public static function getAdminBookingAlertEmails(): array
    {
        $raw = self::getAdminBookingAlertEmailsRaw();
        if ($raw === '') {
            return [];
        }

        $emails = collect(explode(',', $raw))
            ->map(fn (string $email) => strtolower(trim($email)))
            ->filter(fn (string $email) => $email !== '' && filter_var($email, FILTER_VALIDATE_EMAIL))
            ->unique()
            ->values()
            ->all();

        return $emails;
    }

    public static function setCustomerBookingEmailUseQueue(bool $enabled): void
    {
        self::putBool(self::KEY_CUSTOMER_BOOKING_EMAIL_USE_QUEUE, $enabled);
    }

    public static function shouldQueueCustomerBookingEmail(): bool
    {
        return self::getBool(self::KEY_CUSTOMER_BOOKING_EMAIL_USE_QUEUE, true);
    }
}
