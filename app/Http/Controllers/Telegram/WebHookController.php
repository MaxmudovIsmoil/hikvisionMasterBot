<?php

namespace App\Http\Controllers\Telegram;

use App\Http\Controllers\Controller;
use SergiX44\Nutgram\Nutgram;

class WebHookController extends Controller
{
    /**
     * Handle the telegram webhook request.
     */
    public function __invoke(Nutgram $bot)
    {
        $bot->run();
    }
}
