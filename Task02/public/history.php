<?php
require '../src/database.php';
$db = connectDatabase();
$games = $db->query("SELECT * FROM games ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>История игр</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>История игр</h1>
    <table border="1">
        <tr>
            <th>Игрок</th>
            <th>Выражение</th>
            <th>Правильный ответ</th>
            <th>Ответ игрока</th>
            <th>Результат</th>
            <th>Дата</th>
        </tr>
        <?php foreach ($games as $game) : ?>
            <tr>
                <td><?php echo htmlspecialchars($game['player_name']); ?></td>
                <td><?php echo htmlspecialchars($game['expression']); ?></td>
                <td><?php echo $game['correct_answer']; ?></td>
                <td><?php echo $game['user_answer']; ?></td>
                <td><?php echo $game['result']; ?></td>
                <td><?php echo $game['created_at']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a href="index.php">Вернуться к игре</a>
</body>
</html>
