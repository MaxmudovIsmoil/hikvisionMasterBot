<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
