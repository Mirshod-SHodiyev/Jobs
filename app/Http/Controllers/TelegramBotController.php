<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Services\BotCommandFactory;
use Illuminate\Support\Facades\Cache;
use App\Commands\AdsCommand;

class TelegramBotController extends Controller
{
    public function handle(Request $request)
    {
        try {
            $update = Telegram::getWebhookUpdate();
            $chatId = $update->getMessage()->getChat()->getId();
            $messageText = trim($update->getMessage()->getText());
               
            $adminChatId = config('app.admin_chat_id');

            // 🟢 Holatni tekshirish
            $state = Cache::get("admin_state_$chatId");

            if ($state === 'waiting_for_ads') {
                $adsCommand = new AdsCommand();
                return $adsCommand->handleResponse($request);
            }

            // 🟢 Agar `/ads` bo‘lsa va admin bo‘lsa
            if ($messageText === '/ads' && $chatId == $adminChatId) {
                $commandHandler = new AdsCommand();
                return $commandHandler->handle($request);
            }

            // 🟢 Foydalanuvchi holatini tekshiramiz
            $state = Cache::get("user_state_$chatId", 'default');

            // 🟢 Agar foydalanuvchi vakansiya jarayonida bo‘lsa, VakansiyaCommand'ni ishlatamiz
            if ($state !== 'default' || mb_strtolower($messageText) === 'vakansiya joylash') {
                $commandHandler = new \App\Commands\VakansiyaCommand();
            } else {
                $commandHandler = BotCommandFactory::getCommandHandler($messageText);
            }
            if ($state !== 'default' || mb_strtolower($messageText) === 'rezume joylash') {
                $commandHandler = new \App\Commands\RezumeCommand();
            } else {
                $commandHandler = BotCommandFactory::getCommandHandler($messageText);
            }

            // 🟢 Buyruq topildi, handle() funksiyasini ishga tushiramiz
            if ($commandHandler) {
                return $commandHandler->handle($request);
            }

            // 🔴 Agar hech qanday buyruq topilmasa, foydalanuvchiga xabar yuboramiz
            return Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "Noto'g'ri buyruq! Qaytadan urinib ko'ring."
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
