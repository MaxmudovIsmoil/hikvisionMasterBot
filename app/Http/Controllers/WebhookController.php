<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use SergiX44\Nutgram\Nutgram;

class WebhookController extends Controller
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(Nutgram $bot)
    {
//        $message    = $request['message'] ?? [];
//        $chatId    = $message['chat']['id'] ?? null;
//        $firstName = $message['from']['first_name'] ?? '';
//        $text       = $message['text'] ?? '';
        Log::info('webhook command');
//        if ($text == '/start') {
//            Telegram::sendSharePhoneBtn($chatId, $firstName);
//        }
//        Telegram::sendMessage($chatId, "Salom");

        $bot->run();
    }
}
