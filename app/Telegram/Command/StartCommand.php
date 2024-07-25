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

        $bot->sendMessage(
            text: 'Welcome!',
            reply_markup: ReplyKeyboardMarkup::make()->addRow(
                KeyboardButton::make('Give me food!'),
                KeyboardButton::make('Give me animal!'),
            )
        );
    }

}
