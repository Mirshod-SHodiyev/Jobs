<?php

namespace App\Commands;

use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Keyboard\Keyboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StartCommand
{
    public function handle(Request $request)
    {
        $update = Telegram::getWebhookUpdate();
        $message = $update->getMessage();
        $chat = $message->getChat();
        $chatId = $chat->getId(); 
        $firstName = $chat->getFirstName(); 

        $exists = DB::table('users')->where('chat_id', $chatId)->exists();
        if (!$exists) {
            DB::table('users')->insert([
                'chat_id' => $chatId,
                'name' => $firstName,
               
            ]);
        }

        $keyboard = Keyboard::make()
            ->setResizeKeyboard(true)
            ->setOneTimeKeyboard(true)
            ->row([
                Keyboard::button('Vakansiya joylash'),
                Keyboard::button('Rezume joylash'),
            ])
            ->row([
                Keyboard::button('Hamkorlikda ishlash'),
                Keyboard::button("O'quv markaz joylash")
            ]);

        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => "Asalomu alaykum, $firstName! 👋 Xush kelibsiz, o'zingizga kerakli bo'limni tanlang",
            'reply_markup' => $keyboard
        ]);
    }
}
