<?php

namespace App\Console\Commands;

use App\Telegram\Command\StartCommand;
use Illuminate\Console\Command;
use SergiX44\Nutgram\Nutgram;

class BotPolling extends Command
{
    protected $signature = 'bot:polling';
    protected $description = 'Start bot polling';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        //
    }
}
