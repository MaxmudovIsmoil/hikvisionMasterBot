<?php

namespace App\Telegram\Command;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use SergiX44\Nutgram\Nutgram;

class WebhookCommand extends Controller
{
    public function __invoke(Nutgram $bot)
    {
        $bot->run();
    }
}
