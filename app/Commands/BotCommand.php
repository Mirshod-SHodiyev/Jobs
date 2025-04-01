<?php

namespace App\Commands;

use Illuminate\Console\Command;

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
