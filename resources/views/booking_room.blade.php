<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Конференции.РФ — Записаться</title>
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
<div class="header">
<a href="{{ Route('dashboard') }}">
<h1>Конференции.РФ</h1>
</a>
</div>

<div class="container">
<div class="room-detail">
    <h2>{{ $room->name }}</h2>
    <img src="{{ asset('storage/rooms/' . $room->image) }}" alt="{{ $room->name }}" class="room-detail-img">
    <p>{{ $room->description }}</p>

    <form action="{{ Route('booking.store') }}" method="POST">
    @csrf
    <input type="hidden" name="room_id" value="{{ $room->id }}">

    <label for="date">Дата</label>
    <input type="date" name="date" id="date">

    <label for="payment">Способ оплаты</label>
    <select name="payment" id="payment">
    <option value="cash">Наличные</option>
    <option value="sbp">СБП</option>
    </select>

    <button type="submit">Записаться</button>
    </form>

    <a href="{{ Route('dashboard') }}" class="btn-back">Назад</a>
</div>
</div>
</body>
</html>
