<?php

namespace App\Commands;

use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Facades\Cache;
use Telegram\Bot\Keyboard\Keyboard;

class BackCommand
{
    public function handle(Request $request)
    {
        $update = Telegram::getWebhookUpdate();
        $chatId = $update->getMessage()->getChat()->getId();

        Cache::forget("vakansiya_state_$chatId");
        Cache::forget("vacancy_$chatId.workplace");
        Cache::forget("vacancy_$chatId.technology");
        Cache::forget("vacancy_$chatId.experience");
        Cache::forget("vacancy_$chatId.address");
        Cache::forget("vacancy_$chatId.application");
        Cache::forget("vacancy_$chatId.salary");
        Cache::forget("vacancy_$chatId.extra");

        Cache::forget("rezume_state_$chatId");
        Cache::forget("rezume_$chatId.username");
        Cache::forget("rezume_$chatId.technology");
        Cache::forget("rezume_$chatId.experience");
        Cache::forget("rezume_$chatId.address");
        Cache::forget("rezume_$chatId.application");
        Cache::forget("rezume_$chatId.time");
        Cache::forget("rezume_$chatId.salary");
        Cache::forget("rezume_$chatId.extra");

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
            'text' => "Asosiy menyuga qaytdingiz.",
            'reply_markup' => $keyboard
        ]);
    }
}
