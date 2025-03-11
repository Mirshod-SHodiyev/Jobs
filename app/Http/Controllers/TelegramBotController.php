<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Models\Habit;
use Illuminate\Support\Facades\Cache;
use Laravel\Prompts\Key;
use Telegram\Bot\FileUpload\InputFile;
use App\Models\Surah;

class TelegramBotController extends Controller
{
    public function handle(Request $request)
    {
        try {
          

            $update = Telegram::getWebhookUpdate();
            
        
            $chatId = $update->getMessage()->getChat()->getId();
            $messageText = $update->getMessage()->getText();

            if ($messageText === '/start') {
                $keyboard = Keyboard::make()
                    ->setResizeKeyboard(true)
                    ->row([
                        Keyboard::button('Oyatlar'),
                        Keyboard::button('Suralar'),
                    ])
                    ->row([
                        Keyboard::button('Oyat test'),
                        Keyboard::button('duolar')
                  
                    ]);

                Telegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => "Asalomu alaykum, Xush kelibsiz 👋 o'zingizga kerakli bo'limni tanlang tanlang",
                    'reply_markup' => $keyboard
                ]);
            }
        } catch (\Exception $exception) {
            report($exception);
            return response('error', 200);
        }
    }
}