<?php

namespace App\Commands;

use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Facades\Cache;
use Telegram\Bot\Keyboard\Keyboard;

class TasdiqlaymanCommand
{
    public function handle(Request $request)
    {
        $update = Telegram::getWebhookUpdate();
        $chatId = $update->getMessage()->getChat()->getId();
        
        // Vakansiya yoki Rezume ekanligini aniqlash
        $vakansiyaState = Cache::get("vakansiya_state_$chatId");
        $rezumeState = Cache::get("rezume_state_$chatId");
        
        if ($vakansiyaState === 'confirming') {
            $this->processVacancyConfirmation($chatId);
        } elseif ($rezumeState === 'confirming') {
            $this->processResumeConfirmation($chatId);
        } else {
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "Tasdiqlash uchun hech qanday ariza topilmadi."
            ]);
        }
    }
    
    protected function processVacancyConfirmation($chatId)
    {
        // Vakansiya ma'lumotlarini olish
        $workplace = Cache::get("vacancy_$chatId.workplace");
        $technology = Cache::get("vacancy_$chatId.technology");
        $experience = Cache::get("vacancy_$chatId.experience");
        $address = Cache::get("vacancy_$chatId.address");
        $application = Cache::get("vacancy_$chatId.application");
        $time = Cache::get("vacancy_$chatId.time");
        $salary = Cache::get("vacancy_$chatId.salary");
        $extra = Cache::get("vacancy_$chatId.extra");

        $adminChatId = config('app.admin_chat_id');

        $adminMessage = "📢 *Yangi vakansiya:* \n";
        $adminMessage .= "🏢  *Tashkilot:* $workplace\n";
        $adminMessage .= "🛠  *Texnologiyalar:* $technology\n";
        $adminMessage .= "💼 *Tajriba:* $experience\n";
        $adminMessage .= "📌 *Manzil:* $address\n";
        $adminMessage .= "📞 *Murojat:* $application\n";
        $adminMessage .= "🕒 *Ish vaqt:* $time\n";
        $adminMessage .= "💰 *Ish haqi:* $salary\n";
        $adminMessage .= "💡 *Qo'shimcha ma'lumot:* $extra\n\n";
        $adminMessage .= "#" . str_replace(' ', '_', trim($workplace)) . " ";
        $adminMessage .= "#ish #vakansiya ";
        $technologies = explode(',', $technology);
        $formattedTechnologies = array_map(fn($tech) => '#' . trim($tech), $technologies);
        $adminMessage .= implode(' ', $formattedTechnologies);
        // Bu yerda ma'lumotlarni bazaga yozish yoki adminlarga yuborish logikasi bo'lishi kerak
        
        // Keshni tozalash
      
        
        Telegram::sendMessage([
            'chat_id' => $adminChatId,
            'text' => $adminMessage,
            'parse_mode' => 'Markdown',
        ]);
        
        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => "✅ Ma'lumotlaringiz admin tekshiruvidan o'tkazish uchun yuborildi.",
            'parse_mode' => 'Markdown',
        ]);
        $this->clearVacancyCache($chatId);
        // Asosiy menyuga qaytish
        $this->showMainMenu($chatId);
    }
    
    protected function processResumeConfirmation($chatId)
    {
        // Rezume ma'lumotlarini olish

        $username = Cache::get("rezume_$chatId.username");
        $job = Cache::get("rezume_$chatId.job");
        $technology = Cache::get("rezume_$chatId.technology");
        $experience = Cache::get("rezume_$chatId.experience");
        $address = Cache::get("rezume_$chatId.address");
        $application = Cache::get("rezume_$chatId.application");
        $time = Cache::get("rezume_$chatId.time");
        $salary = Cache::get("rezume_$chatId.salary");
        $extra = Cache::get("rezume_$chatId.extra");

        $adminChatId = config('app.admin_chat_id');

        // Rezumeni saqlash yoki yuborish logikasi
        $adminMessage = "📄 *REZYUME* 📄\n\n";
        $adminMessage .= "👤 *Ism Familiya:* $username\n";
        $adminMessage .= " 👔 *Kasb:* $job\n";
        $adminMessage .= "🛠  *Texnologiyalar:* $technology\n";
        $adminMessage .= "💼 *Tajriba:* $experience\n";
        $adminMessage .= "📌 *Manzil:* $address\n";
        $adminMessage .= "📞 *Murojat:* $application\n";
        $adminMessage .= "🕒 *Ish vaqt:* $time\n";
        $adminMessage .= "💰 *Ish haqi:* $salary\n";
        $adminMessage .= "💡 *Qo'shimcha ma'lumot:* $extra\n\n";
        $adminMessage .= "#" . str_replace(' ', '_', trim($username)) . " ";
        $adminMessage .= "#ish #vakansiya ";
        $technologies = explode(',', $technology);
        $formattedTechnologies = array_map(fn($tech) => '#' . trim($tech), $technologies);
        $adminMessage .= implode(' ', $formattedTechnologies);

        
        // Bu yerda ma'lumotlarni bazaga yozish yoki adminlarga yuborish logikasi bo'lishi kerak
        Telegram::sendMessage([
            'chat_id' => $adminChatId,
            'text' => $adminMessage,
            'parse_mode' => 'Markdown',
        ]);
        // Foydalanuvchiga xabar yuborish
        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => "✅ Ma'lumotlaringiz admin tekshiruvidan o'tkazish uchun yuborildi.",
            'parse_mode' => 'Markdown',
        ]);
         
        // Keshni tozalash
        $this->clearResumeCache($chatId);
        // Asosiy menyuga qaytish
        $this->showMainMenu($chatId);
    }
    
    protected function clearVacancyCache($chatId)
    {
        Cache::forget("vakansiya_state_$chatId");
        Cache::forget("vacancy_$chatId.workplace");
        Cache::forget("vacancy_$chatId.technology");
        Cache::forget("vacancy_$chatId.experience");
        Cache::forget("vacancy_$chatId.address");
        Cache::forget("vacancy_$chatId.application");
        Cache::forget("vacancy_$chatId.time");
        Cache::forget("vacancy_$chatId.salary");
        Cache::forget("vacancy_$chatId.extra");
    }
    
    protected function clearResumeCache($chatId)
    {
        Cache::forget("rezume_state_$chatId");
        Cache::forget("rezume_$chatId.username");
        Cache::forget("rezume_$chatId.job");
        Cache::forget("rezume_$chatId.technology");
        Cache::forget("rezume_$chatId.experience");
        Cache::forget("rezume_$chatId.address");
        Cache::forget("rezume_$chatId.application");
        Cache::forget("rezume_$chatId.time");
        Cache::forget("rezume_$chatId.salary");
        Cache::forget("rezume_$chatId.extra");
    }
    
    protected function showMainMenu($chatId)
    {
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
            'text' => "Asosiy menyuga qaytdingiz. Qanday xizmat kerak?",
            'reply_markup' => $keyboard
        ]);
    }
}