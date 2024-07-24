<?php

namespace App\Http\Controllers;

use App\Facades\Telegram;
use Illuminate\Http\Request;
use SergiX44\Nutgram\Nutgram;

class WebhookController extends Controller
{
    public function __invoke(Nutgram $bot)
    {
//        $message    = $request['message'] ?? [];
//        $chatId    = $message['chat']['id'] ?? null;
//        $firstName = $message['from']['first_name'] ?? '';
//        $text       = $message['text'] ?? '';
//
//        if ($text == '/start') {
//            Telegram::sendSharePhoneBtn($chatId, $firstName);
//        }
//
//        Telegram::sendMessage($chatId, "Salom");

        $bot->run();
    }
}
