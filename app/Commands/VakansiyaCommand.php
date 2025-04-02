<?php

namespace App\Commands;

use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Facades\Cache;
use Telegram\Bot\Keyboard\Keyboard;

class VakansiyaCommand
{
    public function handle(Request $request)
    {
        $update = Telegram::getWebhookUpdate();
        $chatId = $update->getMessage()->getChat()->getId();
        $messageText = trim($update->getMessage()->getText());

        // Endi umumiy user_state o'rniga vakansiya_state dan foydalanamiz
        $state = Cache::get("vakansiya_state_$chatId", 'default');

        if ($messageText === 'Vakansiya joylash') {
            Cache::put("vakansiya_state_$chatId", 'asking_workplace', now()->addMinutes(10));

            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "Vakansiya joylash bo‘yicha ariza. Sizga bir necha savollar beriladi, har biriga javob bering.",
            ]);
            $keyboard = Keyboard::make()
            ->setResizeKeyboard(true)
            ->setOneTimeKeyboard(false) // Tugmalar yo‘qolmasligi uchun
            ->row([Keyboard::button("Orqaga")]); // Massiv qilib yozamiz
        
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "Tashkilot nomini kiriting:",
                'reply_markup' => $keyboard,
            ]);
        }
        
        elseif ($state === 'asking_workplace') {
            Cache::put("vacancy_$chatId.workplace", $messageText, now()->addMinutes(10));
            Cache::put("vakansiya_state_$chatId", 'asking_technology', now()->addMinutes(10));
        
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "Ishda talab qilinadigan texnologiyalarni kiriting masalan php , javascript, python agar  boshqa kasb bo'lsa xodim nimani bilishini yozing vergul bilan ajratib yozing"
            ]);
        }
        elseif ($state === 'asking_technology') {
            Cache::put("vacancy_$chatId.technology", $messageText, now()->addMinutes(10));
            Cache::put("vakansiya_state_$chatId", 'asking_experience', now()->addMinutes(10)); 
        
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "Ishda talab qilinadigan tajribangizni kiriting masalan 3 yil, 1 yil yoki 2 yil"
            ]);
        }
        elseif ($state === 'asking_experience') {
            Cache::put("vacancy_$chatId.experience", $messageText, now()->addMinutes(10));
            Cache::put("vakansiya_state_$chatId", 'asking_address', now()->addMinutes(10));
        
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "Tashkilotnin manzilini kiriting agar onlayn  bo'lsa onlayn deb yozing:"
            ]);
        }
        elseif ($state === 'asking_address') {
            Cache::put("vacancy_$chatId.address", $messageText, now()->addMinutes(10));
            Cache::put("vakansiya_state_$chatId", 'asking_application', now()->addMinutes(10));
        
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "Murojat uchun telegram manzilini yoki nomerini kiriting masalan @username yoki +998901234567 silka qoldiring :"
            ]);
        }
        elseif ($state === 'asking_application') {
            Cache::put("vacancy_$chatId.application", $messageText, now()->addMinutes(10));
            Cache::put("vakansiya_state_$chatId", 'asking_time', now()->addMinutes(10));
        
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "Ish vaqtini kiriting: masalan 8:00 - 17:00"
            ]);
        }
        elseif ($state === 'asking_time') {
            Cache::put("vacancy_$chatId.time", $messageText, now()->addMinutes(10));
            Cache::put("vakansiya_state_$chatId", 'asking_salary', now()->addMinutes(10));
        
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "Ish haqi miqdorini kiriting masalan 100$:"
            ]);
        }
        elseif ($state === 'asking_salary') {
            Cache::put("vacancy_$chatId.salary", $messageText, now()->addMinutes(10));
            Cache::put("vakansiya_state_$chatId", 'asking_extra', now()->addMinutes(10));
        
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "Qo'shimcha ma'lumot kiriting masalan sizni Tashkilotiz xodimga nima taklif beradi yoki xodimdan yana qo'shimcha nimani talab qilasiz"
            ]);
        }
        elseif ($state === 'asking_extra') {
            Cache::put("vacancy_$chatId.extra", $messageText, now()->addMinutes(10));
            Cache::put("vakansiya_state_$chatId", 'confirming', now()->addMinutes(10));
        
            $workplace = Cache::get("vacancy_$chatId.workplace");
            $vacancyTechnology = Cache::get("vacancy_$chatId.technology");
            $vacancyExperience = Cache::get("vacancy_$chatId.experience");
            $vacancyAddress = Cache::get("vacancy_$chatId.address");
            $vacancyApplication = Cache::get("vacancy_$chatId.application");
            $vacancyTime = Cache::get("vacancy_$chatId.time");
            $vacancySalary = Cache::get("vacancy_$chatId.salary");
            $vacancyExtra = Cache::get("vacancy_$chatId.extra");
        
            $message = "📢 *Yangi vakansiya:* \n\n";
            $message .= "🏢 *Kompaniya:* $workplace\n\n";
            $message .= "🛠  *Texnologiya:* $vacancyTechnology\n\n"; // To'g'ri nomlash
            $message .= "💼 *Tajriba:* $vacancyExperience\n\n"; // To'g'ri nomlash
            $message .= "📌 *Manzil:* $vacancyAddress\n\n"; // To'g'ri nomlash
            $message .= "📞 *Murojat:* $vacancyApplication\n\n"; // To'g'ri nomlash
            $message .= "💰 *Ish haqi:* $vacancySalary\n\n"; // To'g'ri nomlash
            $message .= "🕒 *Ish vaqt:* $vacancyTime\n\n"; // To'g'ri nomlash
            $message .= "💡 *Qo'shimcha ma'lumot:* $vacancyExtra\n\n"; // To'g'ri nomlash
            $message .= "Agar kiritgan malumotlar to'g'ri bo'lsa, 'Tasdiqlayman' tugmasini bosing.";
                
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
