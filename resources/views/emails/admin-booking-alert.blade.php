<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Booking Alert</title>
</head>
<body style="font-family: Arial, sans-serif; color: #1f2937; line-height: 1.6;">
    <h2 style="margin-bottom: 8px;">New paid booking received</h2>
    <p style="margin-top: 0;">A customer completed payment and a booking was created.</p>

    <h3 style="margin-top: 24px; margin-bottom: 8px;">Booking details</h3>
    <p style="margin: 4px 0;"><strong>Booking ID:</strong> #{{ $booking->id }}</p>
    <p style="margin: 4px 0;"><strong>Customer:</strong> {{ $booking->customer_name }}</p>
    <p style="margin: 4px 0;"><strong>Email:</strong> {{ $booking->customer_email }}</p>
    <p style="margin: 4px 0;"><strong>Phone:</strong> {{ $booking->customer_phone ?: 'N/A' }}</p>
    <p style="margin: 4px 0;"><strong>Date & time:</strong> {{ optional($booking->starts_at)->format('Y-m-d h:i A') }}</p>
    <p style="margin: 4px 0;"><strong>Service:</strong> {{ $booking->menu?->service?->name_en ?? 'N/A' }}</p>
    <p style="margin: 4px 0;"><strong>Menu:</strong> {{ $booking->menu?->title_en ?? $booking->menu?->title ?? 'N/A' }}</p>
    <p style="margin: 4px 0;"><strong>Payment status:</strong> {{ $booking->payment_status }}</p>
    <p style="margin: 4px 0;"><strong>Payment method:</strong> {{ strtoupper((string) $booking->payment_method) }}</p>
    <p style="margin: 4px 0;"><strong>Notes:</strong> {{ $booking->notes ?: 'N/A' }}</p>
</body>
</html>
