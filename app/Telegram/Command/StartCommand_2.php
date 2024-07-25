<?php

namespace App\Telegram\Command;

use App\Facades\Telegram;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;

class StartCommand_2 extends Conversation
{
    protected ?string $step = 'start';

    public function start(Nutgram $bot): void
    {
        $chatId = $bot->chatId();
        if (Telegram::userChatIdDoesntExist($chatId)) {
            $name = Telegram::getName($bot);
            $text = "Assalomu alaykum <b>" . $name . "</b> botga hush kelibsiz.\nIltimos telefon raqamingizni kiriting!\nMisol uchun: 901234567";
            $bot->sendMessage(
                text: $text,
                parse_mode: ParseMode::HTML,
                reply_markup: ReplyKeyboardMarkup::make(resize_keyboard: true)
                    ->addRow(
                        KeyboardButton::make(text: "📱 Telefon raqamni jo'natish", request_contact: true),
                    )
            );
            $this->next('phoneStep');
        }
        else {
            $text = '<b>'.Telegram::getName($bot). "</b> savolingiz bo'lsa adminga murojaat qiling";
            $bot->sendMessage(
                text: $text,
                parse_mode: ParseMode::HTML,
                reply_markup: ReplyKeyboardMarkup::make(resize_keyboard: true)
                    ->addRow(
                        KeyboardButton::make(text: "Shahsiy kabinet"),
                        KeyboardButton::make(text: "Yordam"),
                    )
            );
        }
    }


    public function phoneStep(Nutgram $bot)
    {
        $chatId = $bot->chatId();
        if ($bot->message()->contact)
        {
            $phone = $bot->message()->contact->phone_number;
            $this->phoneShareOrInput($bot, $phone, $chatId);
        }
        else
        {
            $phone = $bot->message()->text;
            if (Telegram::checkPhoneNumber($phone))
            {
                $this->phoneShareOrInput($bot, $phone, $chatId);
            }
            else
            {
                $bot->sendMessage("🚫 Telefon raqam noto'g'ri.\nIltimos qaytadan kiriting!");
            }
        }
    }


    public function phoneShareOrInput(object $bot, string $phone, int $chatId)
    {
        $user = Telegram::checkPhoneAndGetUser($phone, $chatId);
        if ($user !== null) {
            $text = "Hush kelibsiz <b>" . $user->name . "</b> siz bilan ishlashdan mamnunmiz!";
            $bot->sendMessage(
                text: $text,
                parse_mode: ParseMode::HTML,
                reply_markup: ReplyKeyboardMarkup::make(resize_keyboard: true)
                    ->addRow(
                        KeyboardButton::make(text: "Shahsiy kabinet"),
                        KeyboardButton::make(text: "Yordam"),
                    )
            );
            $this->next('menuMainStep');
        }
        else {
            $bot->sendMessage("🚫 Telefon raqam noto'g'ri.\nIltimos qaytadan kiriting!");
        }
    }

}
