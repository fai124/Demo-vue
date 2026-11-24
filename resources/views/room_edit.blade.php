<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Конференции.РФ — Редактировать зал</title>
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
<h2>Редактирование зала</h2>

<form action="{{ Route('room.update', $room->id) }}" method="POST" enctype="multipart/form-data">
@csrf

<label for="name">Название зала</label>
<input type="text" name="name" id="name" value="{{ $room->name }}">

<label for="description">Описание</label>
<textarea name="description" id="description">{{ $room->description }}</textarea>

@if($room->image)
<div class="current-image">
    <img src="{{ asset('storage/rooms/' . $room->image) }}" alt="{{ $room->name }}">
</div>
@endif

<label for="image">Новое изображение</label>
<input type="file" name="image" id="image">
<input type="hidden" name="old_image" value="{{ $room->image }}">

<button type="submit">Сохранить</button>
</form>

<a href="{{ Route('dashboard') }}" class="btn-back">Назад</a>
</div>
</div>
</body>
</html>
