<?php

namespace Funskrip\Calculator;

use Funskrip\Calculator\View;

class Controller
{
    public static function startGame()
    {
        View::showMessage("=== Welcome to the game 'Calculator'! ===");
    }
}
