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
                    ->setOneTimeKeyboard(true)
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
                    'text' => "Vakansiya bo‘yicha joylash ariza.Sizga bir necha savolar beriladi savolarni har biriga javob bering",

                ]);
                Telegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => "Ish joyini kiriting:"
                ]);
            } elseif ($state === 'asking_workplace') {
                Cache::put("vacancy_$chatId.workplace", $messageText, now()->addMinutes(5));
                Cache::put("user_state_$chatId", 'asking_technology', now()->addMinutes(5));
            
                Telegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => "Ishda talab qilinadigan texnologiyalarni kiriting:"
                ]);
            }
            elseif ($state === 'asking_technology') {
                Cache::put("vacancy_$chatId.technology", $messageText, now()->addMinutes(5));
                Cache::put("user_state_$chatId", 'asking_experience', now()->addMinutes(5)); 
            
                Telegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => "Ishda talab qilinadigan tajribani kiriting:"
                ]);
            }
            elseif ($state === 'asking_experience') {
                Cache::put("vacancy_$chatId.experience", $messageText, now()->addMinutes(5));
                Cache::put("user_state_$chatId", 'asking_address', now()->addMinutes(5));
            
                Telegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => "Ish joyi manzilini kiriting(onlayn yoki ofline):"
                ]);
            }elseif ($state === 'asking_address') {
                Cache::put("vacancy_$chatId.address", $messageText, now()->addMinutes(5));
                Cache::put("user_state_$chatId", 'asking_application', now()->addMinutes(5));
            
                Telegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => "Murojat uchun telegram manzilini yoki nomerini kiriting :"
                ]);
            }elseif ($state === 'asking_application') {
                Cache::put("vacancy_$chatId.application", $messageText, now()->addMinutes(5));
                Cache::put("user_state_$chatId", 'asking_time', now()->addMinutes(5));
            
                Telegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => "Ish vaqtini  kiriting:"
                ]);
            }elseif ($state === 'asking_time') {
                Cache::put("vacancy_$chatId.time", $messageText, now()->addMinutes(5));
                Cache::put("user_state_$chatId", 'asking_salary', now()->addMinutes(5));
            
                Telegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => "Ish haqi miqdorini kiriting:"
                ]);
            }elseif ($state === 'asking_salary') {
                Cache::put("vacancy_$chatId.salary", $messageText, now()->addMinutes(5));
                Cache::put("user_state_$chatId", 'asking_extra', now()->addMinutes(5));
            
                Telegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => "Qo'shimcha ma'lumot kiriting:"
                ]);
            }

            elseif ($state === 'asking_extra') {
                Cache::put("vacancy_$chatId.extra", $messageText, now()->addMinutes(5));
                Cache::put("user_state_$chatId", 'confirming', now()->addMinutes(5));
            
                // Ma'lumotlarni olish
                $workplace = Cache::get("vacancy_$chatId.workplace");
                $technology = Cache::get("vacancy_$chatId.technology");
                $experience = Cache::get("vacancy_$chatId.experience");
                $address = Cache::get("vacancy_$chatId.address");
                $application = Cache::get("vacancy_$chatId.application");
                $time = Cache::get("vacancy_$chatId.time");
                $salary = Cache::get("vacancy_$chatId.salary");
                $extra = Cache::get("vacancy_$chatId.extra");

            
                $message = "📋*Ish bo'yicha:* \n\n";
                $message .= "🏢 *Kompaniya:* $workplace\n\n";
                $message .= "🛠  *Texnologiya:* $technology\n\n";
                $message .= "💼 *Tajriba:* $experience\n\n";
                $message .= "📌 *Manzil:* $address\n\n";
                $message .= "📞 *Murojat:* $application\n\n";
                $message .= "💰 *Ish haqi:* $salary\n\n";
                $message .= "🕒 *Ish vaqt:* $time\n\n";
                $message .= "💡 *Qo'shimcha ma'lumot:* $extra\n\n";
                $message .= "Tasdiqlash uchun 'Tasdiqlayman' tugmasini bosing.";
            
                $keyboard = Keyboard::make()
                    ->setResizeKeyboard(true)
                    ->setOneTimeKeyboard(true)
                    ->row([Keyboard::button('Tasdiqlayman✅'), Keyboard::button('Tasdiqlamayman❌')]);
            
                Telegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => $message,
                    'parse_mode' => 'Markdown',
                    'reply_markup' => $keyboard
                ]);
            }
            elseif ($state === 'confirming' && $messageText === 'Tasdiqlayman') {
                $workplace = Cache::get("vacancy_$chatId.workplace");
                $technology = Cache::get("vacancy_$chatId.technology");
                $experience = Cache::get("vacancy_$chatId.experience");
                $time = Cache::get("vacancy_$chatId.time");
                $application = Cache::get("vacancy_$chatId.application");
                $address = Cache::get("vacancy_$chatId.address");
                $extra = Cache::get("vacancy_$chatId.extra");
                $salary = Cache::get("vacancy_$chatId.salary");
                        
                $adminChatId = 791952688;

                $adminMessage = "📢 *Yangi Vakansiya Tekshiruv Uchun!* \n\n";
                $adminMessage .= "🏢 *Ish joyi:* $workplace\n";
                $adminMessage .= "🛠  *Texnologiyalar:* $technology\n";
                $adminMessage .= "💼 *Tajriba:* $experience\n\n";
                $adminMessage .= "💰 *Ish haqi:* $salary\n";
                $adminMessage .= "🕒 *Ish vaqt:* $time\n";
                $adminMessage .= "📌 *Manzil:* $address\n";
                $adminMessage .= "📞 *Murojat:* $application\n";
                $adminMessage .= "💡 *Qo'shimcha ma'lumot:* $extra\n";
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
            } elseif ($messageText === 'Tasdiqlayman' || $messageText === 'Tasdiqlayman') {
                $keyboard = Keyboard::make()
                    ->setResizeKeyboard(true)
                    ->setOneTimeKeyboard(true)
                    ->row([
                        Keyboard::button('Vakansiya joylash'),
                        Keyboard::button('Rezume joylash'),
                    ])
                    ->row([
                        Keyboard::button('Hamkorlikda ishlash'),
                        Keyboard::button("o'quv markaz joylash")
                    ]);
            }
        } catch (\Exception $exception) {
            report($exception);
            return response('error', 200);
        }
    }
}
