@extends('admin.layouts.app')

@section('title', 'System Settings')

@section('admin-content')
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-page-title">System Settings</h3>
            <p class="admin-muted mb-0 mt-1">Configure global frontend behavior.</p>
        </div>
        <div class="p-4">
            <form method="post" action="{{ route('admin.settings.language-selector') }}" class="admin-card p-3">
                @csrf
                <h5 class="mb-1">Frontend Language Selector</h5>
                <p class="admin-muted mb-3">Enable or disable the language switcher shown in the frontend header.</p>
                <div class="form-check form-switch">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        role="switch"
                        id="language_selector_enabled"
                        name="language_selector_enabled"
                        value="1"
                        @checked($languageSelectorEnabled)
                    >
                    <label class="form-check-label" for="language_selector_enabled">
                        Enable language selector
                    </label>
                </div>
                <p class="text-muted small mt-2 mb-3">When disabled, frontend language is fixed to English.</p>
                <button type="submit" class="btn btn-admin-primary btn-sm">Save setting</button>
            </form>

            <form method="post" action="{{ route('admin.settings.booking-notifications') }}" class="admin-card p-3 mt-3">
                @csrf
                <h5 class="mb-1">Booking Notification Emails (Admin)</h5>
                <p class="admin-muted mb-3">Comma-separated emails that receive immediate alerts when a booking is paid and created.</p>

                <label for="admin_booking_alert_emails" class="form-label">Admin alert emails</label>
                <textarea
                    class="form-control @error('admin_booking_alert_emails') is-invalid @enderror"
                    id="admin_booking_alert_emails"
                    name="admin_booking_alert_emails"
                    rows="3"
                    placeholder="admin1@example.com, admin2@example.com"
                >{{ old('admin_booking_alert_emails', $adminBookingAlertEmails) }}</textarea>
                @error('admin_booking_alert_emails')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror

                <div class="form-check form-switch mt-3">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        role="switch"
                        id="customer_booking_email_use_queue"
                        name="customer_booking_email_use_queue"
                        value="1"
                        @checked(old('customer_booking_email_use_queue', $customerBookingEmailUseQueue))
                    >
                    <label class="form-check-label" for="customer_booking_email_use_queue">
                        Queue customer booking notifications
                    </label>
                </div>

                <p class="text-muted small mt-2 mb-3">
                    When enabled, customer confirmations are queued (recommended). Disable only as a temporary fallback if queue processing is unavailable.
                </p>
                <button type="submit" class="btn btn-admin-primary btn-sm">Save setting</button>
            </form>

            <form method="post" action="{{ route('admin.settings.booking-notifications.test') }}" class="admin-card p-3 mt-3">
                @csrf
                <h5 class="mb-1">Send Test Booking Notifications</h5>
                <p class="admin-muted mb-3">Sends an immediate admin alert and a queued customer confirmation using sample booking data.</p>

                <label for="test_customer_email" class="form-label">Test customer email</label>
                <input
                    type="email"
                    class="form-control @error('test_customer_email') is-invalid @enderror"
                    id="test_customer_email"
                    name="test_customer_email"
                    value="{{ old('test_customer_email') }}"
                    placeholder="customer-test@example.com"
                    required
                >
                @error('test_customer_email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror

                <p class="text-muted small mt-2 mb-3">
                    @if ($customerBookingEmailUseQueue)
                        Queue is enabled: keep queue worker running to deliver customer test emails.
                    @else
                        Queue is disabled: customer test email will be sent immediately.
                    @endif
                </p>
                <button type="submit" class="btn btn-admin-primary btn-sm">Send test notifications</button>
            </form>
        </div>
    </div>
@endsection
