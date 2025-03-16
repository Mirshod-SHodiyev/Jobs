<?php

use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;

use App\Commands\AdsCommand;

Route::post('/ads', [AdsCommand::class, 'handle']);
Route::post('/response', [AdsCommand::class, 'handleResponse']);
