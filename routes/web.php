<?php

use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;

Route::get('/', function () {
    return view('welcome');
});

Route::get('setwebhook', function () {
    $response = Telegram::setWebhook([
        'url' =>'https://da26-188-113-245-47.ngrok-free.app/api/telegram/webhook'
    ]);

    return $response;
});