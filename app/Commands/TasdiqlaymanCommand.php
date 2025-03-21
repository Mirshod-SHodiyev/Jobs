<?php

namespace App\Commands;

use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Keyboard\Keyboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TasdiqlaymanCommand
{
    public function handle(Request $request)
    {
        $update = Telegram::getWebhookUpdate();
        $message = $update->getMessage();
        $chat = $message->getChat();
        $chatId = $chat->getId(); 
        $firstName = $chat->getFirstName(); 
        $messageText = trim($update->getMessage()->getText());
        
        if ($messageText === 'Vakansiya joylash' ||  $messageText === 'Rezume joylash' || $messageText === 'Hamkorlikda ishlash' || $messageText === "o'quv markaz joylash") {
            
       
        $keyboard = Keyboard::make()
        ->setResizeKeyboard(true)
        ->setOneTimeKeyboard(true)
        ->row([
            Keyboard::button('Vakansiya joylash'),
            Keyboard::button('Rezume joylash'),
        ])
        ->row([
            Keyboard::button('Hamkorlikda ishlash'),
            Keyboard::button("o'quv markaz joylash")
        ]);
     }
    }
}
