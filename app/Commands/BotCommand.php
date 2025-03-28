<?php

namespace App\Commands;
use Telegram\Bot\Commands\Command;

class BotCommand extends Command
{
    protected $signature = 'bot:run';
    protected $description = 'Run the Telegram bot';

    public function handle()
    {
        $this->info('Bot started successfully!');
        // Bu yerga bot logikasini yozing
    }
}
