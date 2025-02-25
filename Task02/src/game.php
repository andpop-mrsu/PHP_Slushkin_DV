<?php
require 'database.php';

session_start();

function generateExpression() {
    $operators = ['+', '-', '*'];
    $a = rand(1, 20);
    $b = rand(1, 20);
    $c = rand(1, 20);
    $d = rand(1, 20);
    $op1 = $operators[array_rand($operators)];
    $op2 = $operators[array_rand($operators)];
    $op3 = $operators[array_rand($operators)];
    
    $expression = "$a $op1 $b $op2 $c $op3 $d";
    eval("\$correct_answer = $expression;"); // Вычисляем ответ

    return [$expression, $correct_answer];
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $player_name = "Игрок"; // Можно добавить ввод имени
    $expression = $_POST["expression"];
    $correct_answer = (int) $_POST["correct_answer"];
    $user_answer = (int) $_POST["answer"];
    
    $result = ($user_answer === $correct_answer) ? "Верно" : "Неверно";
    $message = "Ваш ответ: $user_answer. Правильный ответ: $correct_answer. $result.";

    saveGameResult($player_name, $expression, $correct_answer, $user_answer, $result);
} else {
    list($expression, $correct_answer) = generateExpression();
}
