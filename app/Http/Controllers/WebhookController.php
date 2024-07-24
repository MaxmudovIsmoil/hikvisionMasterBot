<?php

namespace App\Http\Controllers;

use App\Facades\Telegram;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function __invoke(Request $request)
    {
        $message    = $request['message'] ?? [];
        $chatId    = $message['chat']['id'] ?? null;
        $firstName = $message['from']['first_name'] ?? '';
        $text       = $message['text'] ?? '';

        if ($text == '/start') {
            Telegram::sendSharePhoneBtn($chatId, $firstName);
        }

        Telegram::sendMessage($chatId, "Salom");

    }
}
