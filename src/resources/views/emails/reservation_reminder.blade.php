<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Reminder</title>

    <style>
    .email-content{
        list-style: none;
    }
    </style>
</head>
<body>
    <h1>Reservation Reminder</h1>
    
    <p>こんにちわ {{ $reservation->user->name }} 様,</p>
    
    <p>ご予約に関するご連絡:</p>
    
    <ul>
        <li class="email-content">Restaurant: {{ $reservation->restaurant->name }}</li>
        <li class="email-content">Date: {{ $reservation->date }}</li>
        <li class="email-content">Time: {{ $reservation->time }}</li>
        <li class="email-content">Time: {{ $reservation->number }}名</li>
    </ul>
    <div>
    <p>ご不明な点、ご変更が必要な場合は、こちらまでご連絡ください。</p>
    </div>
    <div>
    <p>011-0000-0000</p>
    </div>
</body>
</html>