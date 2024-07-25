<?php
/** @var SergiX44\Nutgram\Nutgram $bot */


use App\Telegram\Command\StartCommand;
use Nutgram\Laravel\Facades\Telegram;


//Telegram::onCommand('start', function () {
//    Telegram::sendMessage('Hello, world!');
//});

Telegram::onCommand('start', StartCommand::class);

//$bot->onCommand('start', StartCommand::class);

$bot->onException(function (\SergiX44\Nutgram\Nutgram $bot, \Throwable $exception) {
    \Illuminate\Support\Facades\Log::info($exception->getMessage());

    $chatId = config('nutgram.TELEGRAM_ADMIN_CHAT_ID');
    $bot->sendMessage('Error: ' . $exception->getMessage(), $chatId);
});
