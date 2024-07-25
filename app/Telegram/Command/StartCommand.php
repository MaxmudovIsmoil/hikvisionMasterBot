<?php

namespace App\Telegram\Command;

use App\Helpers\Helper;
use Illuminate\Support\Facades\Log;
use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;

class StartCommand extends Command
{
    protected string $command = 'start';

    public function handle(Nutgram $bot): void
    {
        Log::info('start command');
        $bot->sendMessage('Salom bot Hush kelibsiz');
        $reply_markup = ReplyKeyboardMarkup::make(resize_keyboard: true)->addRow(
            KeyboardButton::make('🧾 Тариф'),
            KeyboardButton::make('📝 Подключить услугу'),
        );

        $bot->sendMessage('Hello', parse_mode: ParseMode::HTML, reply_markup: $reply_markup);
    }

}
