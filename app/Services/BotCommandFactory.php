<?php

namespace App\Services;

use App\Commands\AdsCommand;
use App\Commands\StartCommand;
use App\Commands\RezumeCommand;
use App\Commands\VakansiyaCommand;
use App\Commands\HamkorlikCommand;
use App\Commands\OquvMarkazCommand;



class BotCommandFactory
{
    public static function getCommandHandler($messageText)
    {
        return match ($messageText) {
            '/start' => new StartCommand(),
            'Rezume joylash' => new RezumeCommand(),
            'Vakansiya joylash' => new VakansiyaCommand(),
            'Hamkorlikda ishlash' => new HamkorlikCommand(),
            "o'quv markaz joylash" => new OquvMarkazCommand(),
            '/ads' => new AdsCommand(),
            
            default => null
        };
    }
}
