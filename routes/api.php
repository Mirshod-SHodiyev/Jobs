<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TelegramBotController;
use App\Http\Controllers\RezumeController;
use App\Http\Controllers\SaytUsersController;


Route::post('telegram/webhook', [TelegramBotController::class, 'handle']);

Route::post('/register', [SaytUsersController::class, 'register']);
Route::post('/login', [SaytUsersController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [SaytUsersController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



