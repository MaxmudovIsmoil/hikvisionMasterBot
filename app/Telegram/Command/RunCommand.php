<?php

namespace App\Telegram\Command;

use App\Facades\Telegram;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RunCommand extends Controller
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


        // share phone number
//        if (isset($message['contact']))
//            $this->user_share_phone_save_chat_id($message, $chatId, $firstName);
//        else if (strlen($text) == 13)
//            $this->text_phone_save_chat_id($message, $chatId, $firstName);


         Telegram::sendMessage($chatId, "Salom");

        // task save -> 1 - done or -1 - fail
//        $this->task_done_save($data);

    }
}
