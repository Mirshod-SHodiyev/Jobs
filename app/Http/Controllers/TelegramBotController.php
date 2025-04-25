<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Services\BotCommandFactory;
use Illuminate\Support\Facades\Cache;
use App\Commands\AdsCommand;
use App\Commands\VakansiyaCommand;
use App\Commands\RezumeCommand;
use App\Commands\BackCommand;
use App\Commands\TasdiqlaymanCommand;
use App\Commands\TasdiqlamaymanCommand;
use App\Commands\HamkorlikCommand;
use App\Commands\OquvMarkazCommand;
class TelegramBotController extends Controller
{
    public function handle(Request $request)
    {
        try {
            $update = Telegram::getWebhookUpdate();
            $chatId = $update->getMessage()->getChat()->getId();
            $messageText = trim($update->getMessage()->getText());
            
            $adminChatId = config('app.admin_chat_id');

            $adminState = Cache::get("admin_state_$chatId");
            if ($adminState === 'waiting_for_ads') {
                $adsCommand = new AdsCommand();
                return $adsCommand->handleResponse($request);
            }
            if ($messageText === 'Orqaga') {
                $backCommand = new BackCommand();
                return $backCommand->handle($request);
            }

            $vakansiyaState = Cache::get("vakansiya_state_$chatId", 'default');
            $rezumeState = Cache::get("rezume_state_$chatId", 'default');
            $hamkorState = Cache::get("hamkor_state_$chatId", 'default');
            $educationState = Cache::get("education_state_$chatId", 'default');

            if (str_starts_with($vakansiyaState, 'asking_')) {
                $vakansiyaCommand = new VakansiyaCommand();
                return $vakansiyaCommand->handle($request);
            }

            if (str_starts_with($rezumeState, 'asking_')) {
                $rezumeCommand = new RezumeCommand();
                return $rezumeCommand->handle($request);
            }
            if (str_starts_with($hamkorState, 'asking_')) {
                $hamkorCommand = new HamkorlikCommand();
                return $hamkorCommand->handle($request);
            }
            if (str_starts_with($educationState, 'asking_')) {
                $educationCommand = new OquvMarkazCommand();
                return $educationCommand->handle($request);
            }

            $lowerText = mb_strtolower($messageText);
            
            if ($lowerText === 'vakansiya joylash') {
                $command = new VakansiyaCommand();
                return $command->handle($request);
            }
            
            if ($lowerText === 'rezume joylash') {
                $command = new RezumeCommand();
                return $command->handle($request);
            }
            if($lowerText === 'hamkorlikda ishlash'){
                $command = new HamkorlikCommand();
                return $command->handle($request);
            }
            if($lowerText === "o'quv markaz joylash"){
                $command = new OquvMarkazCommand();
                return $command->handle($request);
            }
            if ($lowerText === 'tasdiqlayman✅') {
                $tasdiqlaymanCommand = new TasdiqlaymanCommand();
                return $tasdiqlaymanCommand->handle($request);
            }
            
            if ($lowerText === 'tasdiqlamayman❌') {
                $tasdiqlamaymanCommand = new TasdiqlamaymanCommand();
                return $tasdiqlamaymanCommand->handle($request);
            }
            $commandHandler = BotCommandFactory::getCommandHandler($messageText);
            if ($commandHandler) {
                return $commandHandler->handle($request);
            }

            return Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "Noto'g'ri buyruq! Qaytadan urinib ko'ring."
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
