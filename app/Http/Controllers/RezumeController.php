<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Telegram\Bot\Laravel\Facades\Telegram;

class RezumeController extends Controller
{
    public function handleRezume(Request $request)
    {
        // JSON dan kelgan ma'lumotni olish
        $update = $request->all();
        
        // Foydalanuvchi yozgan matnni olish
        $messageText = $update['message']['text'] ?? null;
        $chatId = $update['message']['chat']['id'] ?? null;

        if ($messageText === 'Rezume joylash') {
            // Foydalanuvchi holatini saqlash (Keyingi qadamni bilish uchun)
            Cache::put("user_state_$chatId", 'asking_workplace', now()->addMinutes(5));

            // Foydalanuvchiga javob yuborish
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "Vakansiya joylash bo‘yicha ariza. Sizga bir necha savollar beriladi. Har biriga javob bering."
            ]);

            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "Kampaniya nomini kiriting:"
            ]);
        }
    }
}
