<?php

namespace App\Commands;

use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Telegram\Bot\Keyboard\Keyboard;
use Illuminate\Support\Facades\Log;

class HamkorlikCommand
{
    public function handle(Request $request)
    {
        $update = Telegram::getWebhookUpdate();
        $chatId = $update->getMessage()->getChat()->getId();
        $messageText = trim($update->getMessage()->getText());

     
        $lowerText = mb_strtolower($messageText);

        if ($lowerText === 'hamkorlikda ishlash' || $lowerText === 'hamkorlikda ishlash') {
            Cache::put("hamkor_state_$chatId", 'default', now()->addMinutes(15));

            $keyboard = Keyboard::make()
                ->setResizeKeyboard(true)
                ->setOneTimeKeyboard(true)
                ->row([Keyboard::button("Orqaga")]);

            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "Hamkorlikda ishlash bo'limi yaqinda ishga tushadi",
                'reply_markup' => $keyboard,
                'parse_mode' => 'HTML'
            ]);
          
        }

     
    }
}