<?php

namespace App\Commands;

use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class AdsCommand
{
  
    public function handle(Request $request)
    {
        $update = Telegram::getWebhookUpdate();
        $message = $update->getMessage();
        $chatId = $message->getChat()->getId(); 

        if ($chatId != config('app.admin_chat_id')) {
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "⛔ Siz admin emassiz!",
            ]);
            return;
        }

        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => "📢 Reklama matnini kiriting:",
        ]);

        Cache::put("admin_state_$chatId", 'waiting_for_ads', now()->addMinutes(5));
    }

    public function handleResponse(Request $request)
    {
        $update = Telegram::getWebhookUpdate();
        $message = $update->getMessage();
        $chatId = $message->getChat()->getId();
        $text = $message->getText();

       
        $state = Cache::get("admin_state_$chatId");

        if ($state === 'waiting_for_ads') {
        
            Cache::forget("admin_state_$chatId");

            $users = DB::table('users')->pluck('chat_id');

            foreach ($users as $userChatId) {
                Telegram::sendMessage([
                    'chat_id' => $userChatId,
                    'text' => "📢 E'lon: \n$text",
                ]);
            }

            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "✅ Reklama muvaffaqiyatli yuborildi!",
            ]);
        }
    }
}
