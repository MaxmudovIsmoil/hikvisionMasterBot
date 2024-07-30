<?php

namespace App\Telegram\Command;

use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;

class HomeCommand extends Command
{
    public function handle(Nutgram $bot)
    {
        $bot->sendMessage(
            text: 'Bosh sahifa',
            parse_mode: ParseMode::HTML,
            reply_markup: ReplyKeyboardMarkup::make(resize_keyboard: true)
                ->addRow(
                    KeyboardButton::make(text: "Shahsiy kabinet"),
                    KeyboardButton::make(text: "Yordam"),
                )
        );

    }

}
