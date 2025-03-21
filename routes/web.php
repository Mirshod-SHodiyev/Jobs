<?php

use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;

Route::get('/', function () {
    return view('welcome');
});

Route::get('setwebhook', function () {
    $response = Telegram::setWebhook([
        'url' =>'https://fa4b-188-113-210-231.ngrok-free.app/telegram/webhook'
    ]);

    return $response;
});