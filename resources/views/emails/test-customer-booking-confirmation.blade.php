<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Test Booking Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; color: #1f2937; line-height: 1.6;">
    <h2 style="margin-bottom: 8px;">Queued customer email test</h2>
    <p style="margin-top: 0;">
        This is a test customer booking confirmation sent from admin settings.
    </p>

    <p style="margin: 4px 0;"><strong>Recipient:</strong> {{ $recipientEmail }}</p>
    <p style="margin: 4px 0;"><strong>Created at:</strong> {{ now()->format('Y-m-d h:i A') }}</p>

    <p style="margin-top: 20px;">
        If you received this email, queued customer notifications are working.
    </p>
</body>
</html>
