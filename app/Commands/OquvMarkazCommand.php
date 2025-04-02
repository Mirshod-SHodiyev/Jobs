<?php

namespace App\Commands;

use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Telegram\Bot\Keyboard\Keyboard;

class OquvMarkazCommand
{ public function handle(Request $request)
    {
        $update = Telegram::getWebhookUpdate();
        $chatId = $update->getMessage()->getChat()->getId();
        $messageText = trim($update->getMessage()->getText());

        $state = Cache::get("education_state_$chatId", 'default');
        $lowerText = mb_strtolower($messageText);
        if ($lowerText === "o'quv markaz joylash" || $lowerText === "o'quv markaz joylash") {
            Cache::put("education_state_$chatId", 'default', now()->addMinutes(15));

            $keyboard = Keyboard::make()
            ->setResizeKeyboard(true)
            ->setOneTimeKeyboard(true) 
            ->row([Keyboard::button("Orqaga")]); 
        
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "o'quv markaz joylash bo'limi yaqinda ishga tushadi",
                'reply_markup' => $keyboard,
                'parse_mode' => 'HTML'
            ]);
        }
    }
}
