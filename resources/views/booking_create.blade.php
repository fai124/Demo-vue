<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Конференции.РФ — Создать заявку</title>
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
<div class="header">
<a href="{{ Route('dashboard') }}">
<h1>Конференции.РФ</h1>
</a>
</div>

<div class="container">
<div class="form-container">
<h2>Создание заявки</h2>

<form action="{{ Route('booking.store') }}" method="POST">
@csrf

<label for="room_id">Зал</label>
<select name="room_id" id="room_id">
@foreach($rooms as $room)
<option value="{{ $room->id }}">{{ $room->name }}</option>
@endforeach
</select>

<label for="date">Дата</label>
<input type="date" name="date" id="date">

<label for="payment">Способ оплаты</label>
<select name="payment" id="payment">
<option value="cash">Наличные</option>
<option value="sbp">СБП</option>
</select>

<button type="submit">Создать заявку</button>
</form>

<a href="{{ Route('dashboard') }}" class="btn-back">Назад</a>
</div>
</div>
</body>
</html>
