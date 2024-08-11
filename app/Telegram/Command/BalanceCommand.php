<?php

namespace App\Telegram\Command;

use App\Facades\Telegram;
use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;

class BalanceCommand extends Command
{
    public function handle(Nutgram $bot)
    {
        $text = Telegram::balance($bot->chatId());
        $bot->sendMessage(
            text: $text,
            parse_mode: ParseMode::HTML,
            reply_markup: ReplyKeyboardMarkup::make(resize_keyboard: true)
                ->addRow(
                    KeyboardButton::make(text: "7 kun"),
                    KeyboardButton::make(text: "1 oy"),
                    KeyboardButton::make(text: "00:00"),
                )
            ->addRow( KeyboardButton::make(text: "Orqaga qaytish"))
        );

    }

}
