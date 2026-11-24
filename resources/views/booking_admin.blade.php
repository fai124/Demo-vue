<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Конференции.РФ — Панель администратора</title>
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
<div class="header">
<a href="{{ Route('dashboard') }}">
<h1>Конференции.РФ</h1>
</a>
</div>

<div class="container">
<h2>Панель администратора</h2>

<table class="bookings-table">
<thead>
<tr>
<th>№</th>
<th>Пользователь</th>
<th>Зал</th>
<th>Дата</th>
<th>Оплата</th>
<th>Статус</th>
<th>Действия</th>
</tr>
</thead>
<tbody>
@foreach($bookings as $booking)
<tr>
<td>{{ $loop->iteration }}</td>
<td>{{ $booking->user->FIO }}</td>
<td>{{ $booking->room->name }}</td>
<td>{{ $booking->date }}</td>
<td>{{ $booking->payment == 'cash' ? 'Наличные' : 'СБП' }}</td>
<td>{{ $booking->status }}</td>
<td>
<form action="{{ Route('booking.update_status', $booking->id) }}" method="POST" class="form-inline">
@csrf
<select name="status" class="status-select">
<option value="new" {{ $booking->status == 'new' ? 'selected' : '' }}>Новая</option>
<option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Подтверждена</option>
<option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Завершена</option>
</select>
<button type="submit" class="btn-small">Обновить</button>
</form>
</td>
</tr>
@endforeach
</tbody>
</table>

<a href="{{ Route('dashboard') }}" class="btn-back">Назад</a>
</div>
</body>
</html>
