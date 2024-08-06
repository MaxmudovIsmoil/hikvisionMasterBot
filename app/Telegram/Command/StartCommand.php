<?php

namespace App\Telegram\Command;

use App\Facades\Telegram;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;

class StartCommand extends Conversation
{
    protected ?string $step = 'start';

    public function start(Nutgram $bot): void
    {
        $chatId = $bot->chatId();

        if (Telegram::userChatIdDoesntExist($chatId)) {
            $this->sendWelcomeMessage($bot);
            $this->next('phoneStep');
        } else {
            $this->sendAdminContactMessage($bot);
            $this->end();
        }
    }

    private function sendWelcomeMessage(Nutgram $bot): void
    {
        $name = Telegram::getName($bot);
        $text = "Assalomu alaykum <b>{$name}</b> botga hush kelibsiz.\nIltimos telefon raqamingizni kiriting!\nMisol uchun: 901234567";
        $bot->sendMessage(
            text: $text,
            parse_mode: ParseMode::HTML,
            reply_markup: $this->getPhoneRequestKeyboard()
        );
    }

    private function sendAdminContactMessage(Nutgram $bot): void
    {
        $name = Telegram::getName($bot);
        $text = "<b>{$name}</b> savolingiz bo'lsa adminga murojaat qiling";
        $bot->sendMessage(
            text: $text,
            parse_mode: ParseMode::HTML,
            reply_markup: $this->getMainMenuKeyboard()
        );
    }

    private function getPhoneRequestKeyboard(): ReplyKeyboardMarkup
    {
        return ReplyKeyboardMarkup::make(resize_keyboard: true)
            ->addRow(
                KeyboardButton::make(text: "📱 Telefon raqamni jo'natish", request_contact: true),
            );
    }

    private function getMainMenuKeyboard(): ReplyKeyboardMarkup
    {
        return ReplyKeyboardMarkup::make(resize_keyboard: true)
            ->addRow(
                KeyboardButton::make(text: "Shaxsiy kabinet"),
                KeyboardButton::make(text: "Yordam"),
            );
    }

    public function phoneStep(Nutgram $bot): void
    {
        $chatId = $bot->chatId();

        $phone = $bot->message()->contact
            ? $bot->message()->contact->phone_number
            : $bot->message()->text;


        if (Telegram::checkPhoneNumber($phone)) {
            $this->handlePhoneNumber($bot, $phone, $chatId);
        } else {
            $bot->sendMessage("🚫 Telefon raqam noto'g'ri.\nIltimos qaytadan kiriting!");
        }
    }

    private function handlePhoneNumber(Nutgram $bot, string $phone, int $chatId): void
    {
        $group = Telegram::checkPhoneAndGetGroup($phone, $chatId);

        if ($group !== null) {
            $text = "Hush kelibsiz <b>{$group->name}</b> siz bilan ishlashdan mamnunmiz!";
            $bot->sendMessage(
                text: $text,
                parse_mode: ParseMode::HTML,
                reply_markup: $this->getMainMenuKeyboard()
            );
            $this->end();
        }
        else {
            $bot->sendMessage("🚫 Telefon raqam noto'g'ri.\nIltimos qaytadan kiriting!");
        }
    }

}
