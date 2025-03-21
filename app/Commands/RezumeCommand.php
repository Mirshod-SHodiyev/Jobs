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

        $state = Cache::get("user_state_$chatId", 'default');

        if ($messageText === 'Rezume joylash') {
            Cache::put("user_state_$chatId", 'asking_username', now()->addMinutes(5));

            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "Rezume joylash bo‘yicha ariza.Sizga bir necha savolar beriladi savolarni har biriga javob bering",

            ]);
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "Ism  Familiya kiriting:"
            ]);
        }
         elseif ($state === 'asking_username') {
            Cache::put("vacancy_$chatId.username", $messageText, now()->addMinutes(5));
            Cache::put("user_state_$chatId", 'asking_technology', now()->addMinutes(5));
        
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "Siz biladigan texnologiyalarni kiriting:"
            ]);
        }
        elseif ($state === 'asking_technology') {
            Cache::put("vacancy_$chatId.technology", $messageText, now()->addMinutes(5));
            Cache::put("user_state_$chatId", 'asking_experience', now()->addMinutes(5)); 
        
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => " tajribangizni kiriting (1 yil, 2 yil, 3 yil, 4 yil, 5 yil va boshqa): kiriting:"
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
        
           
            $username= Cache::get("vacancy_$chatId.username");
            $technology = Cache::get("vacancy_$chatId.technology");
            $experience = Cache::get("vacancy_$chatId.experience");
            $address = Cache::get("vacancy_$chatId.address");
            $application = Cache::get("vacancy_$chatId.application");
            $time = Cache::get("vacancy_$chatId.time");
            $salary = Cache::get("vacancy_$chatId.salary");
            $extra = Cache::get("vacancy_$chatId.extra");

        
            $message = "📋*Rezume:* \n\n";
            $message .= "👤 *Ism Familya :* $username\n\n";
            $message .= "🛠  *Texnologiya:* $technology\n\n";
            $message .= "💼 *Tajriba:* $experience\n\n";
            $message .= "📌 *Manzil:* $address\n\n";
            $message .= "📞 *Murojat:* $application\n\n";
            $message .= "💰 *Ish haqi:* $salary\n\n";
            $message .= "🕒 *Ish vaqt:* $time\n\n";
            $message .= "💡 *Qo'shimcha ma'lumot:* $extra\n\n";
            $message .= "agar kiritgan malumotlar to'gri bo'lsa  'Tasdiqlayman' tugmasini bosing.";
        
            $keyboard = Keyboard::make()
                ->setResizeKeyboard(true)
               
                ->row([Keyboard::button('Tasdiqlayman✅'), Keyboard::button('Tasdiqlamayman❌')]);
        
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'Markdown',
                'reply_markup' => $keyboard
            ]);
        }
        elseif ($state === 'confirming' && $messageText === 'Tasdiqlayman✅') {
            $username = Cache::get("vacancy_$chatId.username");
            $technology = Cache::get("vacancy_$chatId.technology");
            $experience = Cache::get("vacancy_$chatId.experience");
            $address = Cache::get("vacancy_$chatId.address");
            $application = Cache::get("vacancy_$chatId.application");
            $time = Cache::get("vacancy_$chatId.time");
            $salary = Cache::get("vacancy_$chatId.salary");
            $extra = Cache::get("vacancy_$chatId.extra");

           
         
                    
        
          $adminChatId = config('app.admin_chat_id');

          $adminMessage= "📋*Rezume:* \n";
          $adminMessage.= "👤*Ism Familiya:* $username\n";
          $adminMessage.= "🛠  *Texnologiya:* $technology\n";
          $adminMessage.= "💼 *Tajriba:* $experience\n";
          $adminMessage.= "📌 *Manzil:* $address\n";
          $adminMessage.= "📞 *Murojat:* $application\n";
          $adminMessage.= "💰 *Ish haqi:* $salary\n";
          $adminMessage.= "🕒 *Ish vaqt:* $time\n";
          $adminMessage.= "💡 *Qo'shimcha ma'lumot:* $extra\n\n";
          $adminMessage .= "#" . str_replace(' ', '_', trim($username))." " ;
          $adminMessage .= "#ish #vakansiya ";
          $adminMessage .= "#" . str_replace(' ', '_', trim($username)) . " ";
          $technologies = explode(',', $technology);
          $formattedTechnologies = array_map(fn($tech) => '#' . trim($tech), $technologies);
          $adminMessage .= implode(' ', $formattedTechnologies);
          
        Telegram::sendMessage([
                'chat_id' => $adminChatId,
                'text' => $adminMessage,
                'parse_mode' => 'Markdown',
               
            ]);
            Cache::forget("user_state_$chatId");
            Cache::forget("vacancy_$chatId.username");
            Cache::forget("vacancy_$chatId.technology");
            Cache::forget("vacancy_$chatId.experience");
            Cache::forget("vacancy_$chatId.address");
            Cache::forget("vacancy_$chatId.application");
            Cache::forget("vacancy_$chatId.salary");
            Cache::forget("vacancy_$chatId.extra");

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
                'text' => "✅ Ma'lumotlaringiz admin tekshiruvidan o'tkazish uchun yuborildi.",
                'parse_mode' => 'Markdown',
                'reply_markup' => $keyboard
            ]);
         } elseif ($messageText === 'Tasdiqlamayman❌') {
            Cache::forget("user_state_$chatId");
            Cache::forget("vacancy_$chatId.username");
            Cache::forget("vacancy_$chatId.technology");
            Cache::forget("vacancy_$chatId.experience");
            Cache::forget("vacancy_$chatId.address");
            Cache::forget("vacancy_$chatId.application");
            Cache::forget("vacancy_$chatId.salary");
            Cache::forget("vacancy_$chatId.extra");

           
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
                        'text' => "❌ Ma'lumot yuborilmadi.",
                        'reply_markup' => $keyboard
                    ]);
        }

   
}
}









