<?php

namespace App\Commands;

use Telegram\Bot\Laravel\Facades\Telegram;

class HamkorlikCommand
{
    public function handle($chatId)
    {
        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => "Hamkorlik bo'limi: Hamkorlik turini kiriting."
        ]);
    }
}
