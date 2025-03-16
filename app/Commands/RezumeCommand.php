<?php

namespace App\Commands;

use Telegram\Bot\Laravel\Facades\Telegram;

class RezumeCommand
{
    public function handle($chatId)
    {
        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => "Rezume joylash bo'limi: Iltimos, rezume haqida ma'lumot kiriting."
        ]);
    }
}
