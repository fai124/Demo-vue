<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Конференции.РФ — Мои заявки</title>
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
<div class="header">
<a href="{{ Route('dashboard') }}">
<h1>Конференции.РФ</h1>
</a>
</div>

<div class="container">
<h2>Мои заявки</h2>

<table class="bookings-table">
<thead>
<tr>
<th>№</th>
<th>Зал</th>
<th>Дата</th>
<th>Оплата</th>
<th>Статус</th>
<th>Комментарий</th>
</tr>
</thead>
<tbody>
@foreach($bookings as $booking)
<tr>
<td>{{ $loop->iteration }}</td>
<td>{{ $booking->room->name }}</td>
<td>{{ $booking->date }}</td>
<td>{{ $booking->payment == 'cash' ? 'Наличные' : 'СБП' }}</td>
<td>{{ $booking->status }}</td>
<td>
@if($booking->status == 'completed')
@if(empty($booking->comment))
<form action="{{ Route('booking.review', $booking->id) }}" method="POST">
@csrf
<input type="text" name="comment" placeholder="Оставьте отзыв" class="review-input">
<button type="submit" class="btn-small">Отправить</button>
</form>
@else
{{ $booking->comment }}
@endif
@else
-
@endif
</td>
</tr>
@endforeach
</tbody>
</table>

<a href="{{ Route('dashboard') }}" class="btn-back">Назад</a>
</div>
</body>
</html>
