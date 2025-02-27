<?php
require '../src/game.php';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Калькулятор</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Решите пример:</h1>
    <p><?php echo $expression; ?> = ?</p>

    <form method="POST">
        <input type="text" name="answer" required>
        <input type="hidden" name="expression" value="<?php echo $expression; ?>">
        <input type="hidden" name="correct_answer" value="<?php echo $correct_answer; ?>">
        <button type="submit">Ответить</button>
    </form>

    <?php if (isset($message)) : ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="GET">
        <button type="submit">Обновить пример</button>
    </form>

    <a href="history.php">Посмотреть историю игр</a>
</body>
</html>
