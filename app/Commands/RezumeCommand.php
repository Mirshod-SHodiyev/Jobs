<?php

namespace App\Commands;

use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Facades\Cache;
use Telegram\Bot\Keyboard\Keyboard;

class RezumeCommand
{
    public function handle(Request $request)
    {
        $update = Telegram::getWebhookUpdate();
        $chatId = $update->getMessage()->getChat()->getId();
        $messageText = trim($update->getMessage()->getText());

        $state = Cache::get("rezume_state_$chatId", 'default');

        if (mb_strtolower($messageText) === 'rezume joylash') {
            Cache::put("rezume_state_$chatId", 'asking_username', now()->addMinutes(15));

            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "Rezume joylash bo‘yicha ariza. Sizga bir necha savollar beriladi. Har biriga javob bering.",
            ]);
            
            $keyboard = Keyboard::make()
            ->setResizeKeyboard(true)
            ->setOneTimeKeyboard(true) // Tugmalar yo‘qolmasligi uchun
            ->row([Keyboard::button("Orqaga")]); // Massiv qilib yozamiz
        
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "Ism Familiya kiriting:",
                'reply_markup' => $keyboard,
            ]);
        }
        elseif ($state === 'asking_username') {
            Cache::put("rezume_$chatId.username", $messageText, now()->addMinutes(15));
            Cache::put("rezume_state_$chatId", 'asking_job', now()->addMinutes(15));
        
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "kasbizni yozing (masalan: Frontend dasturchi, Backend dasturchi va hokazo) yoki talaba:"
            ]);
        }
        elseif ($state === 'asking_job') {
            Cache::put("rezume_$chatId.job", $messageText, now()->addMinutes(15));
            Cache::put("rezume_state_$chatId", 'asking_technology', now()->addMinutes(15)); 
        
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "Siz biladigan texnologiyalarni  (masalan: PHP, JavaScript, Python va hokazo) boshqa kasb egasi bo'lsayiz siz biladigan texnologiyani vergul bilan kiring:"
            ]);
        }
        elseif ($state === 'asking_technology') {
            Cache::put("rezume_$chatId.technology", $messageText, now()->addMinutes(15));
            Cache::put("rezume_state_$chatId", 'asking_experience', now()->addMinutes(15)); 
        
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "Tajriba darajangizni kiriting (masalan: 1 yil, 2 yil, 3 yil va hokazo):"
            ]);
        }
        elseif ($state === 'asking_experience') {
            Cache::put("rezume_$chatId.experience", $messageText, now()->addMinutes(10));
            Cache::put("rezume_state_$chatId", 'asking_address', now()->addMinutes(10));
        
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "Siz ishlab biladigan manzilingizni kiriting  masalan: Toshkent shahar,yoki onlayn"
            ]);
        }
        elseif ($state === 'asking_address') {
            Cache::put("rezume_$chatId.address", $messageText, now()->addMinutes(10));
            Cache::put("rezume_state_$chatId", 'asking_application', now()->addMinutes(10));
        
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "Murojat uchun telegram manzili yoki nomerini kiriting masalan: @username yoki +998901234567"
            ]);
        }
        elseif ($state === 'asking_application') {
            Cache::put("rezume_$chatId.application", $messageText, now()->addMinutes(10));
            Cache::put("rezume_state_$chatId", 'asking_time', now()->addMinutes(10));
        
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "Ish vaqtini kiriting (masalan: 9:00 - 18:00)"
            ]);
        }
        elseif ($state === 'asking_time') {
            Cache::put("rezume_$chatId.time", $messageText, now()->addMinutes(10));
            Cache::put("rezume_state_$chatId", 'asking_salary', now()->addMinutes(10));
        
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "Ish haqi miqdorini kiriting (masalan: 100.000 so'm)"
            ]);
        }
        elseif ($state === 'asking_salary') {
            Cache::put("rezume_$chatId.salary", $messageText, now()->addMinutes(10));
            Cache::put("rezume_state_$chatId", 'asking_extra', now()->addMinutes(10));
        
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "Qo'shimcha Maqsadlar, karyera istagi (qisqacha) kiriting"
            ]);
        }
        elseif ($state === 'asking_extra') {
            Cache::put("rezume_$chatId.extra", $messageText, now()->addMinutes(10));
            Cache::put("rezume_state_$chatId", 'confirming', now()->addMinutes(10));
        
            $username = Cache::get("rezume_$chatId.username");
            $job = Cache::get("rezume_$chatId.job");
            $technology = Cache::get("rezume_$chatId.technology");
            $experience = Cache::get("rezume_$chatId.experience");
            $address = Cache::get("rezume_$chatId.address");
            $application = Cache::get("rezume_$chatId.application");
            $time = Cache::get("rezume_$chatId.time");
            $salary = Cache::get("rezume_$chatId.salary");
            $extra = Cache::get("rezume_$chatId.extra");

            $message = "📋*Rezume:* \n\n";
            $message .= "👤 *Ism Familiya:* $username\n\n";
            $message .= " 👔 *Vakansiya:* $job\n\n";
            $message .= "🛠  *Texnologiyalar:* $technology\n\n";
            $message .= "💼 *Tajriba:* $experience\n\n";
            $message .= "📌 *Manzil:* $address\n\n";
            $message .= "📞 *Murojat:* $application\n\n";
            $message .= "🕒 *Ish vaqt:* $time\n\n";
            $message .= "💰 *Ish haqi:* $salary\n\n";
            $message .= "💡 *Qo'shimcha ma'lumot:* $extra\n\n";
            $message .= "Agar kiritgan ma'lumotlar to'g'ri bo'lsa, 'Tasdiqlayman' tugmasini bosing.";
        
            $keyboard = Keyboard::make()
                ->setResizeKeyboard(true)
                ->row([
                    Keyboard::button('Tasdiqlayman✅'),
                    Keyboard::button('Tasdiqlamayman❌')
                ]);
        
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'Markdown',
                'reply_markup' => $keyboard
            ]);
        }
       
       
    }
}
