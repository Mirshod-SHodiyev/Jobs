<?php

namespace App\Commands;

use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class AdsCommand
{
    /**
     * Admin reklama berish jarayonini boshlaydi
     */
    public function handle(Request $request)
    {
        $update = Telegram::getWebhookUpdate();
        $message = $update->getMessage();
        $chatId = $message->getChat()->getId(); 

        // Faqat admin ishlata olishi uchun tekshiramiz
        if ($chatId != config('app.admin_chat_id')) {
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "⛔ Siz admin emassiz!",
            ]);
            return;
        }

        // Admindan reklama matnini kiritishni so‘rash
        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => "📢 Reklama matnini kiriting:",
        ]);

        // Adminning keyingi javobini kutish uchun holatni saqlaymiz
        Cache::put("admin_state_$chatId", 'waiting_for_ads', now()->addMinutes(5));
    }

    /**
     * Admin reklama matnini kiritgandan keyin uni hamma userlarga jo'natadi
     */
    public function handleResponse(Request $request)
    {
        $update = Telegram::getWebhookUpdate();
        $message = $update->getMessage();
        $chatId = $message->getChat()->getId();
        $text = $message->getText();

        // Adminning oldingi holatini tekshirish
        $state = Cache::get("admin_state_$chatId");

        if ($state === 'waiting_for_ads') {
            // Cache'ni tozalash
            Cache::forget("admin_state_$chatId");

            // Barcha foydalanuvchilarni olish
            $users = DB::table('users')->pluck('chat_id');

            // Barcha foydalanuvchilarga reklama yuborish
            foreach ($users as $userChatId) {
                Telegram::sendMessage([
                    'chat_id' => $userChatId,
                    'text' => "📢 E'lon: \n$text",
                ]);
            }

            // Adminga xabar yuborish
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "✅ Reklama muvaffaqiyatli yuborildi!",
            ]);
        }
    }
}
