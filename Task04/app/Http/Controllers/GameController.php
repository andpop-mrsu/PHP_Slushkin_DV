<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class GameController extends Controller
{
    public function index()
    {
        return view('game');
    }

    public function generateExpression()
    {
        $numbers = array_map(fn() => rand(1, 50), range(1, 4));
        $operators = ['+', '-', '*'];
        
        $expression = "{$numbers[0]} {$operators[array_rand($operators)]} {$numbers[1]} {$operators[array_rand($operators)]} {$numbers[2]} {$operators[array_rand($operators)]} {$numbers[3]}";
        
        // Используем eval(), но с безопасной обработкой
        $correctAnswer = $this->evaluateExpression($expression);

        return view('game', compact('expression', 'correctAnswer'));
    }

    private function evaluateExpression($expression)
    {
        // bc_eval не существует, но можно безопасно обработать выражение
        $expression = preg_replace('/[^0-9+\-*\/() ]/', '', $expression); // Убираем лишние символы
        return eval("return $expression;");
    }

    public function checkAnswer(Request $request)
    {
        $request->validate([
            'player_name' => 'required|string|max:255',
            'expression' => 'required|string',
            'user_answer' => 'required|integer',
            'correct_answer' => 'required|integer',
        ]);

        $isCorrect = $request->user_answer == $request->correct_answer;

        Game::create([
            'player_name' => $request->player_name,
            'expression' => $request->expression,
            'user_answer' => $request->user_answer,
            'correct_answer' => $request->correct_answer,
            'is_correct' => $isCorrect,
        ]);

        return redirect()->route('game')->with('message', $isCorrect ? 'Правильно!' : 'Ошибка. Верный ответ: ' . $request->correct_answer);
    }

    public function history()
    {
        $games = Game::latest()->get();
        return view('history', compact('games'));
    }
}
