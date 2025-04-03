<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>История игр</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <h1>История игр</h1>
    <table border="1">
        <tr>
            <th>Игрок</th>
            <th>Выражение</th>
            <th>Ответ игрока</th>
            <th>Правильный ответ</th>
            <th>Результат</th>
            <th>Дата</th>
        </tr>
        @foreach($games as $game)
        <tr>
            <td>{{ $game->player_name }}</td>
            <td>{{ $game->expression }}</td>
            <td>{{ $game->user_answer }}</td>
            <td>{{ $game->correct_answer }}</td>
            <td>{{ $game->is_correct ? '✅' : '❌' }}</td>
            <td>{{ $game->played_at }}</td>
        </tr>
        @endforeach
    </table>
    <br>
    <a href="{{ route('game') }}">Играть снова</a>
</body>
</html>
