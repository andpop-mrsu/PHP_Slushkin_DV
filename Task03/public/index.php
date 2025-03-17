<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

use Funskrip\calculator\GameController;
use Funskrip\calculator\Database;
use Funskrip\calculator\Game;

$app = AppFactory::create();

$app->addBodyParsingMiddleware();

$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$dbPath = __DIR__ . '/../db/calculator.sqlite';
$db = new Database($dbPath);
$game = new Game();
$gameController = new GameController($db, $game);

$app->get('/games', function (Request $request, Response $response) use ($gameController) {
    $games = $gameController->getDatabase()->getGameResults();
    $payload = json_encode($games);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/games/{id}', function (Request $request, Response $response, array $args) use ($gameController) {
    $gameId = (int)$args['id'];
    $game = $gameController->getDatabase()->getGameResult($gameId);
    if ($game) {
        $payload = json_encode($game);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    } else {
        return $response->withStatus(404);
    }
});

$app->post('/games', function (Request $request, Response $response) use ($gameController) {
    $data = json_decode($request->getBody());
    $playerName = $data->player_name;

    $expressionData = $gameController->getGame()->generateExpression();

    if ($expressionData['expression'] === null) {
        $payload = json_encode(['error' => 'Failed to generate expression']);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
    } else {
        $gameResult = [
            'expression' => $expressionData['expression'],
            'result' => $expressionData['result'],
            'player_name' => $playerName
        ];

        $gameId = $gameController->getDatabase()->createGame($gameResult);
        $payload = json_encode([
            'id' => $gameId,
            'expression' => $gameResult['expression'],
            'result' => $gameResult['result']
        ]);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }
});

$app->post('/step/{id}', function (Request $request, Response $response, array $args) use ($gameController) {
    $gameId = (int)$args['id'];
    $data = json_decode($request->getBody());
    $playerAnswer = $data->player_answer;
    $expression = $data->expression;
    $result = (float)$data->result;
    $playerName = $data->player_name;

    $gameResult = $gameController->startGameWithData($playerName, $expression, $result, $playerAnswer); // 'is_correct' => $isCorrect

    if (isset($gameResult['error'])) {
        $payload = json_encode($gameResult);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    } else {
        $gameController->getDatabase()->saveStep($gameId, $gameResult);
        $payload = json_encode($gameResult);

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
});

$app->get('/', function (Request $request, Response $response) {
    $html = file_get_contents(__DIR__ . '/index.html');
    $response->getBody()->write($html);
    return $response->withHeader('Content-Type', 'text/html');
});

$app->run();
