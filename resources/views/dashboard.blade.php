<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Конференции.РФ</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>

<body>
    <div class="header">
        <a href="{{ Route('dashboard') }}">
            <img class="photo" src="{{ asset('storage/imgbin-orange.jpg') }}" alt="1">
            <h1>Конференции.РФ</h1>
        </a>
        <div>
    @auth
    <span>{{ Auth::user()->FIO }}</span>
    <form action="{{ Route('logout') }}" method="POST" class="form-inline">
        @csrf
        <button type="submit" class="btn-logout">Выйти</button>
    </form>
    @else
    <a href="{{ Route('login') }}" class="btn-create">Войти</a>
    <a href="{{ Route('register') }}" class="btn-create">Регистрация</a>
    @endauth
    </div>
    </div>

    <div class="container">
        <div class="welcome">
            @auth
            <h2>Добро пожаловать, {{ Auth::user()->FIO }}!</h2>

            @if ( Auth::user()->role !== 'admin' )
            <a href="{{ Route('booking.my') }}" class="btn-create">Мои заявки</a>
            @endif

            @if ( Auth::user()->role == 'admin' )
            <a href="{{ Route('room.create') }}" class="btn-create">Создать зал</a>
            <a href="{{ Route('booking.admin') }}" class="btn-create">Панель администратора</a>
            @endif
            @endauth
        </div>

        <div class="rooms">
            <h3>Залы</h3>
            @foreach ( $rooms as $room )
            @if ( !Str::contains($room->name, 'удален') )
            <div class="room-card">
                <a href="{{ Route('booking.room', $room->id) }}" class="room-link">
                    <img src="{{ asset('storage/rooms/' . $room->image) }}" alt="{{ $room->name }}" class="room-image">
                </a>
                <div class="room-info">
                    <a href="{{ Route('booking.room', $room->id) }}" class="room-link">{{ $room->name }}</a>
                    <p>{{ $room->description }}</p>
                    @if ( Auth::user()->role == 'admin' )
                    <a href="{{ Route('room.edit', $room->id) }}" class="btn-booking">Редактировать</a>
                    @else
                    <a href="{{ Route('booking.room', $room->id) }}" class="btn-booking">Записаться</a>
                    @endif
                </div>
                @auth
                @if ( Auth::user()->role == 'admin' )
                <form action="{{ Route('room.delete', $room) }}" method="POST" class="form-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete">Удалить</button>
                </form>
                @endif
                @endauth
            </div>
            @endif
            @endforeach
        </div>
    </div>

</body>

</html>
