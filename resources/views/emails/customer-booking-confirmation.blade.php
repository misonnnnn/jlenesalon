<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Booking Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; color: #1f2937; line-height: 1.6;">
    <h2 style="margin-bottom: 8px;">Thank you for your booking request</h2>
    <p style="margin-top: 0;">Your payment has been received and your booking is now pending confirmation.</p>

    <h3 style="margin-top: 24px; margin-bottom: 8px;">Booking details</h3>
    <p style="margin: 4px 0;"><strong>Booking ID:</strong> #{{ $booking->id }}</p>
    <p style="margin: 4px 0;"><strong>Name:</strong> {{ $booking->customer_name }}</p>
    <p style="margin: 4px 0;"><strong>Email:</strong> {{ $booking->customer_email }}</p>
    <p style="margin: 4px 0;"><strong>Phone:</strong> {{ $booking->customer_phone ?: 'N/A' }}</p>
    <p style="margin: 4px 0;"><strong>Date & time:</strong> {{ optional($booking->starts_at)->format('Y-m-d h:i A') }}</p>
    <p style="margin: 4px 0;"><strong>Service:</strong> {{ $booking->menu?->service?->name_en ?? 'N/A' }}</p>
    <p style="margin: 4px 0;"><strong>Menu:</strong> {{ $booking->menu?->title_en ?? $booking->menu?->title ?? 'N/A' }}</p>
    <p style="margin: 4px 0;"><strong>Notes:</strong> {{ $booking->notes ?: 'N/A' }}</p>

    <p style="margin-top: 24px;">We will review your request and contact you if any follow-up is needed.</p>
    <p style="margin-top: 16px;">Jlene Salon</p>
</body>
</html>
