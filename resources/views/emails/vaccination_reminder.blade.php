<!DOCTYPE html>
<html>
<head>
    <title>Vaccination Reminder</title>
</head>
<body>
    <h1>Hello {{ $user->name }},</h1>
    <p>This is a reminder for your scheduled vaccination.</p>
    <p>
        <strong>Date:</strong> {{ \Carbon\Carbon::parse($user->registration->scheduled_date)->format('l, F j, Y') }}
    </p>

    <h2>Vaccine Center Details</h2>
    <p><strong>Name:</strong> {{ $vaccineCenter->name }}</p>
</body>
</html>
