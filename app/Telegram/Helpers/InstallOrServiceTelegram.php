<?php

namespace App\Telegram\Helpers;

use App\Models\Group;
use App\Models\CategoryInstall;
use SergiX44\Nutgram\Nutgram;
use Nutgram\Laravel\Facades\Telegram;
use Illuminate\Support\Facades\Log;
use App\Helpers\Helper;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;

class InstallOrServiceTelegram
{

    public static function getText(int $type, array $data): string
    {
        if($type == 1) {
            $categoryName = CategoryInstall::findOrFail($data['category_id'])->name ?? "";
            $text = "O'rnatish xizmat: <b>" . $categoryName . "</b>\n";
            $text .= "Blanka raqami: " . $data['blanka_number'] . "\n";
            $text .= "Soni: " . $data['quantity'] . "\n";
        }
        else {
            $text = "<b>Servis xizmat:</b>\n";
            $text .= "Blanka raqami: " . $data['blanka_number'] . "\n";
        }


        $text .= "Narx: " . Helper::moneyFormat($data['price']) . "\n";
        if ($data['description']) {
            $text .= "Izoh: " . $data['description'] . "\n";
        }
        $text .= "Mijoz ismi: " . $data['name'] . "\n";
        $text .= "Telefon raqam: <code>". Helper::phoneFormatForTelegram($data['phone'])."</code>\n";
        $text .= "Huqud: ". $data['area']."\n";
        $text .= "Manzil: ". $data['address']."\n";
        $text .= "Lokatsiya: ". $data['location']."\n";
        return $text;
    }



    public static function send(int $type, int $id, int $groupId, string $text):void
    {
        // $type = 1 install, 2 service
        $groupChatId = Group::findOrFail($groupId)->chatId;
        if(!empty(Group::findOrFail($groupId)->chatId))
        {
            Telegram::sendMessage(text: $text, chat_id: $groupChatId,
                reply_markup: InlineKeyboardMarkup::make()
                    ->addRow(
                        InlineKeyboardButton::make('✅ Qabul qilish', callback_data: "$type:$id:1"),
                        InlineKeyboardButton::make('❌ Rad etish', callback_data: "$type:$id:0")
                    ),
                parse_mode: ParseMode::HTML
            );
        }
    }


    public function okeyOrCancel()
    {
        $data = Telegram::callbackQuery()->data;
        $type = explode(':', $data)[0];
        $id = explode(':', $data)[1];
        $status   = explode(':', $data)[2];

        if ($status === '1') {
            $icon = "✅";
            $message = '✅ okey';
        }
        else {
            $message = "❌ no";
        }

        Telegram::sendMessage($data);

//        $text = Telegram::update()->callback_query->message->text;
//        Log::info(json_encode($text));
//        Telegram::sendMessage(json_encode($text));

//        Telegram::editMessageText($text, [
//            'parse_mode' => ParseMode::HTML,
//        ]);

        Telegram::answerCallbackQuery();
    }


}
