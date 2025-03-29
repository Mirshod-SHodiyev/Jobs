<?php

use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;

Route::get('/', function () {
    return view('welcome');
});

// Webhook o'rnatish uchun endpoint
Route::get('/setwebhook', function () {
    $response = Telegram::setWebhook([
        'url' => 'https://jobuzall.uz/telegram/webhook',
        'secret_token' => env('TELEGRAM_WEBHOOK_SECRET'),
        'max_connections' => 50,
        'allowed_updates' => ['message', 'callback_query']
    ]);
    
    return response()->json($response);
});

// Telegram webhook uchun asosiy endpoint
Route::post('/telegram/webhook', function () {
    // Secret tokenni tekshirish
    if (request()->header('X-Telegram-Bot-Api-Secret-Token') !== env('TELEGRAM_WEBHOOK_SECRET')) {
        abort(403, 'Invalid token');
    }
    
    // Xabarni qayta ishlash
    $update = Telegram::commandsHandler(true);
    
    return response()->json(['status' => 'success']);
});