<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Facades\Cache;
use App\Models\Vacancy;

class TelegramBotController extends Controller
{
    public function handle(Request $request)
    {
        try {
            $update = Telegram::getWebhookUpdate();
            $chatId = $update->getMessage()->getChat()->getId();
            $messageText = $update->getMessage()->getText();

            $state = Cache::get("user_state_$chatId", 'default');

            if ($messageText === '/start') {
                $keyboard = Keyboard::make()
                    ->setResizeKeyboard(true)
                    ->row([
                        Keyboard::button('Vakansiya joylash'),
                        Keyboard::button('Rezume joylash'),
                    ])
                    ->row([
                        Keyboard::button('Hamkorlikda ishlash'),
                        Keyboard::button("o'quv markaz joylash")
                    ]);

                Telegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => "Asalomu alaykum, Xush kelibsiz 👋 o'zingizga kerakli bo'limni tanlang",
                    'reply_markup' => $keyboard
                ]);
            } elseif ($messageText === 'Vakansiya joylash') {
                Cache::put("user_state_$chatId", 'asking_workplace', now()->addMinutes(5));

                Telegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => "Vakansiya bo‘yicha ariza. Iltimos, ish joyini kiriting:"
                ]);
            } elseif ($state === 'asking_workplace') {
                Cache::put("vacancy_$chatId.workplace", $messageText, now()->addMinutes(5));
                Cache::put("user_state_$chatId", 'asking_technology', now()->addMinutes(5));

                Telegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => "Ishda talab qilinadigan texnologiyalarni kiriting:"
                ]);
            } elseif ($state === 'asking_technology') {
                Cache::put("vacancy_$chatId.technology", $messageText, now()->addMinutes(5));
                Cache::put("user_state_$chatId", 'asking_salary', now()->addMinutes(5));

                Telegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => "Ish haqi miqdorini kiriting:"
                ]);
            } elseif ($state === 'asking_salary') {
                Cache::put("vacancy_$chatId.salary", $messageText, now()->addMinutes(5));
                Cache::put("user_state_$chatId", 'confirming', now()->addMinutes(5));

                // Tasdiqlash uchun shablon yaratish
                $workplace = Cache::get("vacancy_$chatId.workplace");
                $technology = Cache::get("vacancy_$chatId.technology");
                $salary = Cache::get("vacancy_$chatId.salary");

                $message = "📌 *Vakansiya Ma'lumotlari:* \n\n";
                $message .= "🏢 *Ish joyi:* $workplace\n";
                $message .= "🖥 *Talab qilinadigan texnologiyalar:* $technology\n";
                $message .= "💰 *Ish haqi:* $salary\n\n";
                $message .= "Tasdiqlash uchun 'Tasdiqlayman' tugmasini bosing.";

                $keyboard = Keyboard::make()
                    ->setResizeKeyboard(true)
                    ->setOneTimeKeyboard(true)
                    ->row([Keyboard::button('Tasdiqlayman')]);

                Telegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => $message,
                    'parse_mode' => 'Markdown',
                    'reply_markup' => $keyboard
                ]);
            } elseif ($state === 'confirming' && $messageText === 'Tasdiqlayman') {
                $workplace = Cache::get("vacancy_$chatId.workplace");
                $technology = Cache::get("vacancy_$chatId.technology");
                $salary = Cache::get("vacancy_$chatId.salary");

                // Admin chat ID ni olish
                $adminChatId =791952688;

                // Admin uchun xabar
                $adminMessage = "📢 *Yangi Vakansiya Tekshiruv Uchun!* \n\n";
                $adminMessage .= "🏢 *Ish joyi:* $workplace\n";
                $adminMessage .= "🖥 *Texnologiyalar:* $technology\n";
                $adminMessage .= "💰 *Ish haqi:* $salary\n";
                $adminMessage .= "\n⏳ Iltimos, vakansiyani tekshirib, kanalga yuklang.";

                Telegram::sendMessage([
                    'chat_id' => $adminChatId,
                    'text' => $adminMessage,
                    'parse_mode' => 'Markdown'
                ]);

                Telegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => "✅ Ma'lumotlaringiz admin tekshiruvidan o'tkazish uchun yuborildi."
                ]);

                // Foydalanuvchi holatini tozalash
                Cache::forget("user_state_$chatId");
                Cache::forget("vacancy_$chatId.workplace");
                Cache::forget("vacancy_$chatId.technology");
                Cache::forget("vacancy_$chatId.salary");
            }

        } catch (\Exception $exception) {
            report($exception);
            return response('error', 200);
        }
    }
}
