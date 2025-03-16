<?php

use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;

Route::get('/', function () {
    return view('welcome');
});

Route::get('setwebhook', function () {
    $response = Telegram::setWebhook([
        'url' =>'  https://89af-188-113-240-49.ngrok-free.app/telegram/webhook'
    ]);

    return $response;
});