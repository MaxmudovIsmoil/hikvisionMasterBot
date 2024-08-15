<?php

namespace App\Telegram\Helpers;

use App\Models\Group;
use App\Models\CategoryInstall;
use App\Models\Install;
use App\Models\Service;
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

    public static function getSendText(int $type, array $data): string
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


    public function okeyOrCancel(Nutgram $bot)
    {
        $callbackData = $bot->callbackQuery()?->data;
        if (!$callbackData) {
            Log::error("Callback data is missing.");
            return;
        }

        $parts = explode(':', $callbackData);
        if (count($parts) < 3) {
            Log::error("Malformed callback data: {$callbackData}");
            return;
        }

        $type = $parts[0];
        $id = $parts[1];
        $status = $parts[2];

        // Log the parsed callback data for debugging purposes
        Log::info("Callback Data - Type: {$type}, ID: {$id}, Status: {$status}");

        try {
            if ($type == 1) {
                $datas = Install::findOrFail($id);
            } else {
                $datas = Service::findOrFail($id);
            }
        } catch (ModelNotFoundException $e) {
            Log::error("Record not found for ID: {$id} and Type: {$type}");
            return;
        }

        $text = self::getAcceptedText($type, $datas);

        $bot->editMessageText(
            text: $text,
            chat_id: $bot->chatId(),
            message_id: $bot->messageId(),
            reply_markup: InlineKeyboardMarkup::make()
                ->addRow(
                    InlineKeyboardButton::make('✅ Ishni yopish', callback_data: "$type:$id:2"),
                    InlineKeyboardButton::make('🛑 Keyinga qoldirish', callback_data: "$type:$id:-1")
                ),
            parse_mode: ParseMode::HTML
        );
        $bot->answerCallbackQuery();

    // Xabarni barcha foydalanuvchilarga yuborish
//        $groupIds = Group::where('status', 1)->get('chatId')->toArray();
//        $userIds = [1068702247, 5882206998]; // Bu erda barcha foydalanuvchi IDlari bo'lishi kerak
//        $messageIdMap = [];
//
//        foreach ($userIds as $userId) {
//            $sentMessage = $bot->sendMessage('Original xabar', $userId);
//            $messageIdMap[$userId] = $sentMessage->message_id; // Yuborilgan xabar ID sini saqlash
//        }

        // Foydalanuvchi xabarni qabul qilganda
//        $bot->onMessage(function ($message) use ($bot, $userIds, $messageIdMap) {
//            $receivedUserId = $message->from->id;
//
//            Log::info('test: '. $receivedUserId);
//            // Xabar olinganidan keyin boshqa foydalanuvchilar uchun xabarni o'zgartirish
//            foreach ($userIds as $userId) {
//                if ($userId != $receivedUserId) {
//                    $bot->editMessageText(
//                        text: 'Yangi xabar matni',
//                        chat_id: $userId,
//                        message_id: $messageIdMap[$userId]
//                    );
//                }
//            }
//        });

    }


    public static function getAcceptedText(int $type, $data): string
    {
        Log::info(json_encode($data->category_id));
        try {
            $text = "✅ Qabul qilindi:\n";
            if($type == 1) {
                $categoryName = CategoryInstall::findOrFail($data->category_id)->name ?? "";
                $text .= "O'rnatish xizmat: <b>" . $categoryName . "</b>\n";
                $text .= "Blanka raqami: " . $data->blanka_number . "\n";
                $text .= "Soni: " . $data->quantity . "\n";
            }
            else {
                $text .= "<b>Servis xizmat:</b>\n";
                $text .= "Blanka raqami: " . $data->blanka_number . "\n";
            }


            $text .= "Narx: " . Helper::moneyFormat($data->price) . "\n";
            if ($data->description) {
                $text .= "Izoh: " . $data->description . "\n";
            }
            $text .= "Mijoz ismi: " . $data->name . "\n";
            $text .= "Telefon raqam: <code>". Helper::phoneFormatForTelegram($data->phone)."</code>\n";
            $text .= "Huqud: ". $data->area."\n";
            $text .= "Manzil: ". $data->address."\n";
            $text .= "Lokatsiya: ". $data->location."\n";
            return $text;
        }
        catch(\Exception $e) {
            return $e->getMessage();
        }
    }



//    public static function accepted(int $type, int $id, string $text, int $chatId, int $messageId ): void
//    {
//        // $type = 1 install, 2 service
//        Telegram::editMessageText(
//            text: $text,
//            chat_id: $groupChatId,
//            message_id: $messageId
//            reply_markup: InlineKeyboardMarkup::make()
//                ->addRow(
//                    InlineKeyboardButton::make('✅ Ishni yopish', callback_data: "$type:$id:2"),
//                    InlineKeyboardButton::make('🛑 Keyinga qoldirish', callback_data: "$type:$id:-1")
//                ),
//            parse_mode: ParseMode::HTML
//        );
//
//    }

}
