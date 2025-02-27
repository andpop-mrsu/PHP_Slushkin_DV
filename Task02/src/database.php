<?php
function connectDatabase() {
    return new PDO('sqlite:../db/calculator.sqlite');
}

function saveGameResult($player_name, $expression, $correct_answer, $user_answer, $result) {
    $db = connectDatabase();
    $stmt = $db->prepare("INSERT INTO games (player_name, expression, correct_answer, user_answer, result) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$player_name, $expression, $correct_answer, $user_answer, $result]);
}
