<?php

namespace App\Http\Controllers;

use App\Mail\AdminBookingAlertMail;
use App\Mail\TestCustomerBookingConfirmationMail;
use App\Models\Booking;
use App\Models\Service;
use App\Models\ServiceMenu;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AdminSettingController extends Controller
{
    public function index()
    {
        return view('admin.settings.index', [
            'languageSelectorEnabled' => SiteSetting::isLanguageSelectorEnabled(),
            'adminBookingAlertEmails' => SiteSetting::getAdminBookingAlertEmailsRaw(),
            'customerBookingEmailUseQueue' => SiteSetting::shouldQueueCustomerBookingEmail(),
        ]);
    }

    public function updateLanguageSelector(Request $request): RedirectResponse
    {
        SiteSetting::setLanguageSelectorEnabled($request->boolean('language_selector_enabled'));

        return redirect()
            ->route('admin.settings.index')
            ->with('status', 'Language selector setting updated successfully.');
    }

    public function updateBookingNotifications(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'admin_booking_alert_emails' => ['nullable', 'string', 'max:2000'],
            'customer_booking_email_use_queue' => ['nullable', 'boolean'],
        ]);

        $raw = trim((string) ($validated['admin_booking_alert_emails'] ?? ''));
        $emails = collect(explode(',', $raw))
            ->map(fn (string $email) => trim($email))
            ->filter(fn (string $email) => $email !== '');

        $invalidEmails = $emails->filter(fn (string $email) => !filter_var($email, FILTER_VALIDATE_EMAIL))->values();
        if ($invalidEmails->isNotEmpty()) {
            return redirect()
                ->route('admin.settings.index')
                ->withErrors([
                    'admin_booking_alert_emails' => 'Invalid email(s): ' . $invalidEmails->implode(', '),
                ])->withInput();
        }

        SiteSetting::setAdminBookingAlertEmails($emails->implode(', '));
        SiteSetting::setCustomerBookingEmailUseQueue($request->boolean('customer_booking_email_use_queue'));

        return redirect()
            ->route('admin.settings.index')
            ->with('status', 'Booking notification emails updated successfully.');
    }

    public function sendTestBookingNotifications(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'test_customer_email' => ['required', 'email', 'max:255'],
        ]);

        $adminEmails = SiteSetting::getAdminBookingAlertEmails();
        if ($adminEmails === []) {
            return redirect()
                ->route('admin.settings.index')
                ->withErrors([
                    'admin_booking_alert_emails' => 'Please set at least one valid admin alert email first.',
                ])->withInput();
        }

        $booking = $this->buildSampleBookingForEmail($validated['test_customer_email']);

        try {
            Mail::to($adminEmails)->send(new AdminBookingAlertMail($booking));
            $testCustomerMail = new TestCustomerBookingConfirmationMail($validated['test_customer_email']);
            if (SiteSetting::shouldQueueCustomerBookingEmail()) {
                Mail::to($validated['test_customer_email'])->queue($testCustomerMail);
            } else {
                Mail::to($validated['test_customer_email'])->send($testCustomerMail);
            }
        } catch (\Throwable $e) {
            Log::error('Failed to send test booking notifications from settings.', [
                'message' => $e->getMessage(),
                'admin_emails' => $adminEmails,
                'customer_email' => $validated['test_customer_email'],
            ]);

            return redirect()
                ->route('admin.settings.index')
                ->withErrors([
                    'test_customer_email' => 'Failed to send test notifications. Please check mail and queue settings.',
                ])->withInput();
        }

        return redirect()
            ->route('admin.settings.index')
            ->with(
                'status',
                SiteSetting::shouldQueueCustomerBookingEmail()
                    ? 'Test notifications sent: admin immediate and customer queued.'
                    : 'Test notifications sent: admin immediate and customer sent immediately (queue disabled).'
            );
    }

    private function buildSampleBookingForEmail(string $testCustomerEmail): Booking
    {
        $service = new Service([
            'name_en' => 'Test Service',
            'name_ja' => 'テストサービス',
        ]);

        $menu = new ServiceMenu([
            'title_en' => 'Test Menu',
            'title_ja' => 'テストメニュー',
            'title' => 'Test Menu',
            'duration' => '60 min',
            'price' => '5000',
        ]);
        $menu->setRelation('service', $service);

        $booking = new Booking([
            'id' => 0,
            'customer_name' => 'Test Customer',
            'customer_email' => $testCustomerEmail,
            'customer_phone' => '000-0000-0000',
            'starts_at' => now()->addDay()->setTime(10, 0),
            'notes' => 'This is a test notification from admin settings.',
            'status' => 'pending',
            'payment_method' => 'card',
            'payment_status' => 'paid',
        ]);
        $booking->setRelation('menu', $menu);

        return $booking;
    }
}
