<?php
/** @var SergiX44\Nutgram\Nutgram $bot */


use App\Jobs\InstallOrServiceSendTelegramJob;
use App\Models\GroupBall;
use App\Telegram\Command\BalanceCommand;
use App\Telegram\Command\GoBackCommand;
use App\Telegram\Command\HomeCommand;
use App\Telegram\Command\PersonalCabinetCommand;
use App\Telegram\Command\StartCommand;
use App\Telegram\Helpers\InstallOrServiceTelegram;
use Nutgram\Laravel\Facades\Telegram;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;


Telegram::onText('/start', StartCommand::class);

Telegram::onText('Bosh sahifa', HomeCommand::class);

Telegram::onText('Shahsiy kabinet', PersonalCabinetCommand::class);

Telegram::onText('Orqaga qaytish', GoBackCommand::class);

Telegram::onText('Balansni tekshirish', BalanceCommand::class);

Telegram::onText('Ball yig’ish uchun nima qilish kerak', function(\SergiX44\Nutgram\Nutgram $bot) {
    $ball = GroupBall::first()->text;
    $bot->sendMessage(text: $ball, parse_mode: ParseMode::HTML);
});

Telegram::onText('Yordam', function (\SergiX44\Nutgram\Nutgram $bot) {
    $bot->sendMessage(
        text: 'Yordam menu',
        parse_mode: ParseMode::HTML,
        reply_markup: ReplyKeyboardMarkup::make(resize_keyboard: true)
            ->addRow(
                KeyboardButton::make(text: "Shahsiy kabinet"),
                KeyboardButton::make(text: "Yordam"),
            )
    );
});


Telegram::onCallbackQuery([InstallOrServiceTelegram::class, 'acceptOrCancel']);

//Telegram::onCallbackQuery(function (\SergiX44\Nutgram\Nutgram $bot) {
//    $chatId = config('nutgram.TELEGRAM_ADMIN_CHAT_ID');
//    $bot->sendMessage('okey',  $chatId);
//});


Telegram::onException(function (\SergiX44\Nutgram\Nutgram $bot, \Throwable $exception) {
    $chatId = config('nutgram.TELEGRAM_ADMIN_CHAT_ID');
    $bot->sendMessage('Error: ' . $exception->getMessage(), $chatId);
});
