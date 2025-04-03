<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Калькулятор</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <h1>Решите выражение:</h1>
    <h2>{{ $expression }}</h2>

    @if(session('message'))
        <p>{{ session('message') }}</p>
    @endif

    <form action="{{ route('check') }}" method="POST">
        @csrf
        <input type="hidden" name="expression" value="{{ $expression }}">
        <input type="hidden" name="correct_answer" value="{{ $correctAnswer }}">
        <input type="text" name="player_name" placeholder="Ваше имя" required>
        <input type="number" name="user_answer" placeholder="Ответ" required>
        <button type="submit">Отправить</button>
    </form>

    <br>
    <a href="{{ route('history') }}">Посмотреть историю игр</a>
</body>
</html>
