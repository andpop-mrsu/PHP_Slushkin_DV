<?php

namespace Funskrip\calculator;

class Game
{
    public function generateExpression(): array
    {
        $operators = ['+', '-', '*'];
        $operands = [];

        for ($i = 0; $i < 4; $i++) {
            $operands[] = rand(1, 10);
        }

        if (empty($operands)) {
            return ['expression' => null, 'result' => null];
        }

        $expression = (string)$operands[0];
        for ($i = 1; $i < 4; $i++) {
            $expression .= $operators[array_rand($operators)] . $operands[$i];
        }

        try {
            error_reporting(0);
            $result = eval('return ' . $expression . ';');
            error_reporting(E_ALL);

            if ($result === false) {
                return ['expression' => null, 'result' => null];
            }

            return [
                'expression' => $expression,
                'result' => $result
            ];
        } catch (\Throwable $e) {
            return ['expression' => null, 'result' => null];
        }
    }
}
