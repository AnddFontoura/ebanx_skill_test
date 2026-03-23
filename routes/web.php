<?php

use App\Http\Controllers\AccountBalanceController;
use App\Http\Controllers\CleanerController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/balance', [AccountBalanceController::class, 'getBalance'])
    ->name('balance')
    ->withoutMiddleware(VerifyCsrfToken::class);

Route::post('/event', [AccountBalanceController::class, 'newBalance'])
    ->name('event')
    ->withoutMiddleware(VerifyCsrfToken::class);

Route::post('/reset', [CleanerController::class, 'clean'])
    ->name('reset')
    ->withoutMiddleware(VerifyCsrfToken::class);
