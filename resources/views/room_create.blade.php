<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Конференции.РФ — Создать зал</title>
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
<h2>Создание зала</h2>

<form action="{{ Route('room.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<label for="name">Название зала</label>
<input type="text" name="name" id="name" placeholder="Введите название">

<label for="description">Описание</label>
<textarea name="description" id="description" placeholder="Введите описание"></textarea>

<label for="image">Изображение</label>
<input type="file" name="image" id="image">

<button type="submit">Создать</button>
</form>

<a href="{{ Route('dashboard') }}" class="btn-back">Назад</a>
</div>
</div>
</body>
</html>
