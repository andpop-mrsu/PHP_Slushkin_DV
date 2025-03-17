<?php

namespace Funskrip\calculator;

class Database
{
    private $pdo;

    public function __construct(string $dbPath)
    {
        $this->pdo = new \PDO("sqlite:" . $dbPath);
        $this->createTables();
    }
    private function createTables()
    {
        try {
            $this->pdo->exec("
                CREATE TABLE IF NOT EXISTS players (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    name TEXT NOT NULL,
                    date DATETIME DEFAULT CURRENT_TIMESTAMP
                );

                CREATE TABLE IF NOT EXISTS games (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    player_id INTEGER NOT NULL,
                    expression TEXT NOT NULL,
                    correct_answer REAL NOT NULL,
                    game_date DATETIME DEFAULT CURRENT_TIMESTAMP,
                    FOREIGN KEY (player_id) REFERENCES players (id)
                );

                CREATE TABLE IF NOT EXISTS steps (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    game_id INTEGER NOT NULL,
                    player_answer REAL NOT NULL,
                    is_correct INTEGER NOT NULL,
                    step_date DATETIME DEFAULT CURRENT_TIMESTAMP,
                    FOREIGN KEY (game_id) REFERENCES games (id)
                );
            ");
        } catch (\PDOException $e) {
            echo "Ошибка при создании таблиц: " . $e->getMessage();
            die();
        }
    }

    public function createGame(array $gameData): int
    {
        try {
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare("INSERT INTO players (name) VALUES (?)");
            $stmt->execute([$gameData['player_name']]);
            $playerId = (int)$this->pdo->lastInsertId();

            $stmt = $this->pdo->prepare("
                INSERT INTO games (player_id, expression, correct_answer)
                VALUES (?, ?, ?)
            ");
            $stmt->execute([$playerId, $gameData['expression'], $gameData['result']]);
            $gameId = (int)$this->pdo->lastInsertId();

            $this->pdo->commit();
            return $gameId;
        } catch (\PDOException $e) {
            $this->pdo->rollBack();
            echo "Ошибка при создании игры: " . $e->getMessage();
            die();
        }
    }

    public function saveStep(int $gameId, array $stepData)
    {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO steps (game_id, player_answer, is_correct)
                VALUES (?, ?, ?)
            ");
            $stmt->execute([$gameId, $stepData['player_answer'], (int)$stepData['is_correct']]);
        } catch (\PDOException $e) {
            echo "Ошибка при сохранении хода игры: " . $e->getMessage();
            die();
        }
    }

    public function getGameResults(): array
    {
        try {
            $stmt = $this->pdo->prepare("
                SELECT 
                    p.name AS player_name,
                    g.expression,
                    g.correct_answer,
                    s.player_answer,
                    s.is_correct,
                    g.game_date
                FROM games g
                JOIN players p ON g.player_id = p.id
                LEFT JOIN steps s ON g.id = s.game_id
                ORDER BY g.game_date DESC
            ");
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Ошибка при получении результатов игр: " . $e->getMessage();
            return [];
        }
    }

    public function getGameResult(int $gameId): array
    {
        try {
            $stmt = $this->pdo->prepare("
                SELECT 
                    p.name AS player_name,
                    g.id AS game_id,
                    g.expression,
                    g.correct_answer,
                    (SELECT player_answer FROM steps WHERE game_id = g.id ORDER BY step_date DESC LIMIT 1) AS player_answer,
                    (SELECT is_correct FROM steps WHERE game_id = g.id ORDER BY step_date DESC LIMIT 1) AS is_correct,
                    g.game_date
                FROM games g
                JOIN players p ON g.player_id = p.id
                WHERE g.id = ?
            ");
            $stmt->execute([$gameId]);
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result ?: [];
        } catch (\PDOException $e) {
            echo "Ошибка при получении результата игры: " . $e->getMessage();
            return [];
        }
    }
}
