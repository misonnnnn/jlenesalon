<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\PaymentMethod;
use App\Models\Service;
use App\Models\ServiceMenu;
use App\Models\SiteSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use JsonException;
use Stripe\Checkout\Session;
use Stripe\Exception\SignatureVerificationException;
use Stripe\StripeClient;
use Stripe\Webhook;

class BookingController extends Controller
{
    private const STRIPE_ZERO_DECIMAL_CURRENCIES = [
        'bif', 'clp', 'djf', 'gnf', 'jpy', 'kmf', 'krw', 'mga',
        'pyg', 'rwf', 'ugx', 'vnd', 'vuv', 'xaf', 'xof', 'xpf',
    ];

    public function create(Request $request)
    {
        $services = Service::query()
            ->where('is_active', true)
            ->with([
                'menus' => fn ($query) => $query->where('is_active', true)->orderBy('sort_order'),
            ])
            ->orderBy('sort_order')
            ->get();

        $preselectedService = $request->query('service');
        $preselectedMenu = $request->query('menu');
        $paymentMethods = PaymentMethod::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $oldMenuId = (int) $request->old('service_menu_id', 0);
        if ($oldMenuId > 0) {
            $oldMenu = ServiceMenu::query()->with('service')->find($oldMenuId);
            if ($oldMenu && $oldMenu->service && $oldMenu->service->is_active) {
                $preselectedService = $oldMenu->service->slug;
            }
        }

        return view('booking', compact('services', 'preselectedService', 'preselectedMenu', 'paymentMethods'));
    }

    public function store(StoreBookingRequest $request): RedirectResponse
    {
        $stripeSecret = (string) config('services.stripe.secret');
        if ($stripeSecret === '') {
            return redirect()
                ->route('bookings.create')
                ->withErrors([
                    'payment' => 'Payment is temporarily unavailable. Please contact the salon.',
                ])->withInput();
        }

        $validated = $request->validated();
        $selectedMethod = strtolower((string) ($validated['payment_method'] ?? 'card'));
        $paymentMethod = PaymentMethod::query()
            ->where('code', $selectedMethod)
            ->where('is_active', true)
            ->first();
        $stripePaymentMethod = $paymentMethod?->stripe_method;
        if ($stripePaymentMethod === null) {
            return redirect()
                ->route('bookings.create')
                ->withErrors([
                    'payment_method' => 'This payment method is currently unavailable for Stripe Checkout.',
                ])->withInput();
        }

        $menu = ServiceMenu::query()
            ->with('service')
            ->where('is_active', true)
            ->findOrFail($validated['service_menu_id']);

        $currency = strtolower((string) config('services.stripe.currency', 'jpy'));
        $unitAmount = $this->parseStripeAmount($menu->price, $currency);
        if ($unitAmount === null || $unitAmount < 1) {
            return redirect()
                ->route('bookings.create')
                ->withErrors([
                    'payment' => 'This menu does not have a valid price for online payment yet.',
                ])->withInput();
        }

        $checkoutReference = (string) Str::uuid();
        Cache::put($this->checkoutPayloadCacheKey($checkoutReference), $validated, now()->addMinutes(60));

        $locale = SiteSetting::isLanguageSelectorEnabled()
            ? session('site_locale', 'ja')
            : 'en';
        $menuName = $locale === 'ja'
            ? ($menu->title_ja ?: $menu->title_en ?: $menu->title ?: 'Salon booking')
            : ($menu->title_en ?: $menu->title_ja ?: $menu->title ?: 'Salon booking');

        try {
            $stripe = new StripeClient($stripeSecret);
            $session = $stripe->checkout->sessions->create([
                'mode' => 'payment',
                'success_url' => route('bookings.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('bookings.cancel'),
                'client_reference_id' => $checkoutReference,
                'customer_email' => $validated['customer_email'],
                'payment_method_types' => [$stripePaymentMethod],
                'line_items' => [[
                    'quantity' => 1,
                    'price_data' => [
                        'currency' => $currency,
                        'unit_amount' => $unitAmount,
                        'product_data' => [
                            'name' => $menuName,
                            'description' => $menu->service?->name_en,
                        ],
                    ],
                ]],
                'metadata' => [
                    'service_menu_id' => (string) $validated['service_menu_id'],
                    'starts_at' => (string) $validated['starts_at'],
                    'payment_method' => $selectedMethod,
                ],
            ]);
        } catch (\Throwable $e) {
            Cache::forget($this->checkoutPayloadCacheKey($checkoutReference));
            Log::error('Stripe Checkout session creation failed.', [
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->route('bookings.create')
                ->withErrors([
                    'payment' => 'Unable to start secure payment. Please try again.',
                ])->withInput();
        }

        return redirect()->away($session->url);
    }

    public function success(Request $request): RedirectResponse
    {
        $sessionId = (string) $request->query('session_id', '');
        if ($sessionId === '') {
            return redirect()->route('bookings.create');
        }

        $stripeSecret = (string) config('services.stripe.secret');
        if ($stripeSecret === '') {
            return redirect()->route('bookings.create');
        }

        try {
            $stripeSession = (new StripeClient($stripeSecret))
                ->checkout
                ->sessions
                ->retrieve($sessionId, []);
        } catch (\Throwable $e) {
            return redirect()->route('bookings.create')
                ->withErrors(['payment' => 'We could not verify your payment yet. Please contact us with your payment receipt.']);
        }

        if (($stripeSession->payment_status ?? null) !== 'paid') {
            return redirect()->route('bookings.create')
                ->withErrors(['payment' => 'Payment is not completed yet.']);
        }

        $this->persistPaidBooking($stripeSession);

        return redirect()
            ->route('bookings.create')
            ->with('status', 'booking_submitted');
    }

    public function cancel(): RedirectResponse
    {
        return redirect()
            ->route('bookings.create')
            ->withErrors(['payment' => 'Payment was cancelled. Your booking was not saved.']);
    }

    public function webhook(Request $request): JsonResponse
    {
        $webhookSecret = (string) config('services.stripe.webhook_secret');
        $signature = (string) $request->header('Stripe-Signature');
        $payload = $request->getContent();

        try {
            $event = $webhookSecret !== ''
                ? Webhook::constructEvent($payload, $signature, $webhookSecret)
                : json_decode($payload, false, 512, JSON_THROW_ON_ERROR);
        } catch (SignatureVerificationException|\UnexpectedValueException|\JsonException $e) {
            return response()->json(['message' => 'Invalid webhook payload.'], 400);
        }

        if (($event->type ?? '') === 'checkout.session.completed') {
            /** @var Session $session */
            $session = $event->data->object;
            if (($session->payment_status ?? null) === 'paid') {
                $this->persistPaidBooking($session);
            }
        }

        return response()->json(['received' => true]);
    }

    public function unavailableSlots(Request $request): JsonResponse
    {
        $start = $request->query('start')
            ? Carbon::parse((string) $request->query('start'))
            : now()->startOfDay();
        $end = $request->query('end')
            ? Carbon::parse((string) $request->query('end'))
            : now()->addMonths(3)->endOfDay();

        $slots = Booking::query()
            ->whereBetween('starts_at', [$start, $end])
            ->where('status', '!=', 'cancelled')
            ->orderBy('starts_at')
            ->pluck('starts_at')
            ->map(function ($value) {
                $date = $value instanceof Carbon ? $value : Carbon::parse($value);

                return $date->format('Y-m-d H:i');
            })
            ->values();

        return response()->json([
            'slots' => $slots,
        ]);
    }

    private function persistPaidBooking(Session $stripeSession): void
    {
        $checkoutSessionId = (string) ($stripeSession->id ?? '');
        if ($checkoutSessionId === '') {
            return;
        }

        $exists = Booking::query()
            ->where('stripe_checkout_session_id', $checkoutSessionId)
            ->exists();
        if ($exists) {
            return;
        }

        $reference = (string) ($stripeSession->client_reference_id ?? '');
        $cacheKey = $this->checkoutPayloadCacheKey($reference);
        $payload = is_string($reference) && $reference !== '' ? Cache::pull($cacheKey) : null;
        if (!is_array($payload)) {
            return;
        }

        Booking::create([
            'service_menu_id' => $payload['service_menu_id'],
            'customer_name' => $payload['customer_name'],
            'customer_email' => $payload['customer_email'],
            'customer_phone' => $payload['customer_phone'] ?? null,
            'starts_at' => $payload['starts_at'],
            'notes' => $payload['notes'] ?? null,
            'status' => 'pending',
            'payment_status' => 'paid',
            'payment_method' => (string) ($payload['payment_method'] ?? 'card'),
            'stripe_amount_total' => isset($stripeSession->amount_total) ? (int) $stripeSession->amount_total : null,
            'stripe_currency' => isset($stripeSession->currency) ? strtoupper((string) $stripeSession->currency) : null,
            'stripe_checkout_session_id' => $checkoutSessionId,
            'stripe_payment_intent_id' => (string) ($stripeSession->payment_intent ?? ''),
        ]);
    }

    private function checkoutPayloadCacheKey(string $reference): string
    {
        return 'stripe_checkout_payload_' . $reference;
    }

    private function parseStripeAmount(?string $rawPrice, string $currency): ?int
    {
        $price = trim((string) $rawPrice);
        if ($price === '') {
            return null;
        }

        $normalized = preg_replace('/[^\d.]/', '', $price);
        if (!is_string($normalized) || $normalized === '') {
            return null;
        }

        $baseAmount = (float) $normalized;
        if ($baseAmount <= 0) {
            return null;
        }

        $multiplier = in_array(strtolower($currency), self::STRIPE_ZERO_DECIMAL_CURRENCIES, true) ? 1 : 100;

        return (int) round($baseAmount * $multiplier);
    }
}
