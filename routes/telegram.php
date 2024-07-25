<?php
/** @var SergiX44\Nutgram\Nutgram $bot */


use App\Models\GroupBall;
use App\Telegram\Command\StartCommand;
use Nutgram\Laravel\Facades\Telegram;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;


Telegram::onText('/start', StartCommand::class);

Telegram::onText('Bosh sahifa', function (\SergiX44\Nutgram\Nutgram $bot) {
    $bot->sendMessage(
        text: 'Bosh sahifa',
        parse_mode: ParseMode::HTML,
        reply_markup: ReplyKeyboardMarkup::make(resize_keyboard: true)
            ->addRow(
                KeyboardButton::make(text: "Shahsiy kabinet"),
                KeyboardButton::make(text: "Yordam"),
            )
    );
});

Telegram::onText('Shahsiy kabinet', function (\SergiX44\Nutgram\Nutgram $bot) {
    $bot->sendMessage(
        text: 'Shahsiy kabinet',
        parse_mode: ParseMode::HTML,
        reply_markup: ReplyKeyboardMarkup::make(resize_keyboard: true)
            ->addRow(
                KeyboardButton::make(text: "Shahsiy kabinet"),
                KeyboardButton::make(text: "Yordam"),
            )
    );
});


//Telegram::onText('/start', function (\SergiX44\Nutgram\Nutgram $bot) {
//    $bot->sendMessage('salom');
//});


Telegram::onText("test", function (\SergiX44\Nutgram\Nutgram $bot) {
    $bot->sendMessage('test message');
});


Telegram::onText('infoBall', function(\SergiX44\Nutgram\Nutgram $bot) {
    $ball = GroupBall::first()->text;
    $bot->sendMessage(text: $ball, parse_mode: ParseMode::HTML);
});


Telegram::onException(function (\SergiX44\Nutgram\Nutgram $bot, \Throwable $exception) {
    $chatId = config('nutgram.TELEGRAM_ADMIN_CHAT_ID');
    $bot->sendMessage('Error: ' . $exception->getMessage(), $chatId);
});
