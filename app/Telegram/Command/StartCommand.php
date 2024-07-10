<?php

namespace App\Telegram\Command;

use SergiX44\Nutgram\Nutgram;

class StartCommand
{
    public function __invoke(Nutgram $bot)
    {
        $bot->sendMessage('Welcome to the bot!');
    }

}
