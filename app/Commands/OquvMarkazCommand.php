<?php

namespace App\Commands;

use Telegram\Bot\Laravel\Facades\Telegram;

class OquvMarkazCommand
{
    public function handle($chatId)
    {
        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => "O'quv markaz bo'limi: O'quv markazi nomini kiriting."
        ]);
    }
}
