<?php

namespace App\Telegram\Command;

use Illuminate\Support\Facades\Log;
use SergiX44\Nutgram\Nutgram;

class StartCommand
{
    public function start(Nutgram $bot)
    {
        Log::info('bot');
        $bot->sendMessage('Welcome to the bot!');
    }

}
