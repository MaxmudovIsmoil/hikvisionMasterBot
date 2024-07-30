<?php

namespace App\Telegram\Command;

use App\Facades\Telegram;
use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;

class GoBackCommand extends Command
{
    public function handle(Nutgram $bot)
    {
        $bot->sendMessage(
            text: 'Orqaga qaytish',
            parse_mode: ParseMode::HTML,
            reply_markup: ReplyKeyboardMarkup::make(resize_keyboard: true)
                ->addRow(
                    KeyboardButton::make(text: "Ball yig’ish uchun nima qilish kerak")
                )
                ->addRow(
                    KeyboardButton::make(text: "Bosh sahifa"),
                    KeyboardButton::make(text: "Balansni tekshirish")
                )
        );
    }
}
