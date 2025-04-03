<?php

use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Route;

Route::get('/', [GameController::class, 'generateExpression'])->name('game');
Route::post('/check', [GameController::class, 'checkAnswer'])->name('check');
Route::get('/history', [GameController::class, 'history'])->name('history');
