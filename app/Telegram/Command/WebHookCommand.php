<?php

namespace App\Telegram\Command;

use App\Http\Controllers\Controller;
use SergiX44\Nutgram\Nutgram;

class WebHookCommand extends Controller
{
    /**
     * Handle the telegram webhook request.
     */
    public function __invoke(Nutgram $bot)
    {
        $bot->run();
    }
}
