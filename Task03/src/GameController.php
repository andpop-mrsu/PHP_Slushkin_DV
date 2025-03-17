<?php

namespace Funskrip\calculator;

use Funskrip\calculator\Database;
use Funskrip\calculator\Game;

class GameController
{
    private Database $db;
    private Game $game;

    public function __construct(Database $db, Game $game)
    {
        $this->db = $db;
        $this->game = $game;
    }

    public function startGameWithData(string $playerName, string $expression, float $result, string $playerAnswer)
    {

        if ($playerAnswer === null || !is_numeric($playerAnswer)) {
            return ['error' => "Пожалуйста, введите числовой ответ."];
        }

        $playerAnswer = (float)$playerAnswer;
        $isCorrect = abs($playerAnswer - $result) < 0.0001;

        return [
            'player_name' => $playerName,
            'expression' => $expression,
            'expected_result' => $result,
            'player_answer' => $playerAnswer,
            'is_correct' => $isCorrect,
        ];
    }

    public function getGame(): Game
    {
        return $this->game;
    }

    public function getDatabase(): Database
    {
        return $this->db;
    }
}
