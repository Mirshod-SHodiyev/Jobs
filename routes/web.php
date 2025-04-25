<?php

use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Http\Controllers\HomeController;



Route::get('/', function () {
    return view('home');
});


Route::get('/setwebhook', function () {
    $response = Telegram::setWebhook([
        'url' =>'https://jobuzall.uz/telegram/webhook',
        'secret_token' => env('TELEGRAM_WEBHOOK_SECRET'),
        'max_connections' => 50,
        'allowed_updates' => ['message', 'callback_query']
    ]);
    
    return response()->json($response);
});

Route::post('/telegram/webhook', function () {
    if (request()->header('X-Telegram-Bot-Api-Secret-Token') !== env('TELEGRAM_WEBHOOK_SECRET')) {
        abort(403, 'Invalid token');
    }
    
    $update = Telegram::commandsHandler(true);
    
    return response()->json(['status' => 'success']);
});
