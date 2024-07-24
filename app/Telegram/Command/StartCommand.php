<?php

namespace App\Telegram\Command;

use App\Facades\Telegram;

class StartCommand
{
    public function start()
    {
        Telegram::sendMessage('Hello');
    }

}
