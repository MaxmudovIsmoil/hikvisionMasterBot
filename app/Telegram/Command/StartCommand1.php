<?php

namespace App\Telegram\Command;

use App\Facades\Telegram;
use App\Helpers\Helper;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;

class StartCommand1 extends Conversation
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
            $bot->sendMessage($text, parse_mode: ParseMode::HTML);
        }

        $this->end();
    }


    public function phoneStep(Nutgram $bot)
    {
        if ($bot->message()->contact)
        {
            $phone = $bot->message()->contact->phone_number;
            $this->phoneShareOrInput($bot, $phone, $bot->chatId());
        }
        else
        {
            $phone = $bot->message()->text;
            if (Telegram::checkPhoneNumber($phone))
            {
                $this->phoneShareOrInput($bot, $phone, $bot->chatId());
            }
            else
            {
                $bot->sendMessage("🚫 Telefon raqam noto'g'ri.\nIltimos qaytadan kiriting!");
            }
        }
    }


    public function menuMainStep(Nutgram $bot)
    {
        $name = Telegram::getName($bot);
        $text = "Assalomu alaykum <b>" . $name . "</b> botga hush kelibsiz.\nIltimos telefon raqamingizni kiriting!\nMisol uchun: 901234567";

        $bot->sendMessage(
            text: 'kabinet menu',
            parse_mode: ParseMode::HTML,
            reply_markup: ReplyKeyboardMarkup::make(resize_keyboard: true)
                ->addRow(
                    KeyboardButton::make(text: "Ball yig’ish uchun nima qilish kerak"),
                )->addRow(
                    KeyboardButton::make(text: "Bosh sahifa"),
                    KeyboardButton::make(text: "Balansni tekshirish")
                )
        );
        $this->next('kabinetMenuStep');
    }

    public function kabinetMenuStep(Nutgram $bot)
    {
        $name = Telegram::getName($bot);
        $text = "Assalomu alaykum <b>" . $name . "</b> botga hush kelibsiz.\nIltimos telefon raqamingizni kiriting!\nMisol uchun: 901234567";
        $bot->sendMessage(
            text: $text,
            parse_mode: ParseMode::HTML,
            reply_markup: ReplyKeyboardMarkup::make(resize_keyboard: true)
                ->addRow(
                    KeyboardButton::make(text: "Ball yig’ish uchun nima qilish kerak"),
                )->addRow(
                    KeyboardButton::make(text: "Bosh sahifa"),
                    KeyboardButton::make(text: "Balansni tekshirish")
                )
        );
        $this->end();
    }


    public function phoneShareOrInput(object $bot, string $phone, int $chatId)
    {
        $user = Telegram::checkPhoneAndGetUser($phone, $chatId);
        $text = "Hush kelibsiz <b>".$user->name ."</b> siz bilan ishlashdan mamnunmiz!";
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

}
