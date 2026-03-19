<?php

use App\Http\Controllers\AccountBalanceController;
use App\Http\Controllers\CleanerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('balance', [AccountBalanceController::class, 'getBalance']);
Route::post('event', [AccountBalanceController::class, 'newBalance']);
Route::post('reset', [CleanerController::class, 'clean']);
