<?php

namespace App\Telegram\Command;

use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Nutgram;

class StartCommand extends Command
{
    protected string $command = 'start';

    public function handle(Nutgram $bot): void
    {
        $bot->sendMessage('Salom bot');
    }

}
