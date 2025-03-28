<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Commands\BotCommand;

class CommandServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        // Quyidagicha ro'yxatdan o'tkazish orqali artisan komandalar ro'yxatiga qo'shamiz
        $this->commands([
            BotCommand::class,
        ]);
    }


}
