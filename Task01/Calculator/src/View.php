<?php

namespace Funskrip\Calculator;

class View
{
    public static function showMessage(string $message)
    {
        \cli\line($message);
    }
}
