<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TelegramBotController;
use App\Http\Controllers\SaytUsersController;
use App\Http\Controllers\UsertypesConroller;

//telegram api
Route::post('telegram/webhook', [TelegramBotController::class, 'handle']);

//auth api
Route::post('/register', [SaytUsersController::class, 'register']);
Route::post('/login', [SaytUsersController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [SaytUsersController::class, 'logout']);

//user types
Route::get('/usertypes', [UsertypesConroller::class, 'index']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



