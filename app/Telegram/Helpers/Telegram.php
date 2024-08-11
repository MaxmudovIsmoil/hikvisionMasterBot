<?php

namespace App\Telegram\Helpers;

use App\Helpers\Helper;
use App\Models\CategoryInstall;
use App\Models\Group;
use Illuminate\Support\Str;

class Telegram
{
    public function getName(?object $bot = null): null|string
    {
        if ($bot === null) {
            return null;
        }

        $user = $bot->user();
        return $user->first_name ?? $user->last_name ?? $user->username;
    }

    public function checkPhoneNumber(string $phone): bool
    {
        $phone_length = Str::length($phone);

        if (($phone_length == 9))
            return $this->phoneIsValid($phone);

        $phone_code = Str::substr($phone, 0, 4);
        $phone = Str::substr($phone, 4, 13);

        if(($phone_length == 13) && ($phone_code == '+998'))
            return $this->phoneIsValid($phone);

        return false;
    }

    public function phoneIsValid(string $phone): bool
    {
        return (bool) preg_match('/^[0-9]{9}$/', $phone);
    }


    public function userChatIdDoesntExist(int $chatId): bool
    {
        return Group::where('chatId', $chatId)->doesntExist();
    }

    public function checkGroupId(int $chatId): ?int
    {
        $group = Group::where('chatId', $chatId)->first();
        return $group?->id;
    }


    public function checkPhoneAndGetGroup(string $phone, int $chatId): ?Group
    {
        if (strlen($phone) > 9) {
            $phone = substr($phone, -9);
        }
        $group = Group::where('phone', $phone)->with('user')->first();

        if ($group) {
            $group->update(['chatId' => $chatId]);
            return $group;
        }
        return null;
    }


    public function getGroup(int $chatId): object|string|null
    {
        try {
            return Group::where('chatId', $chatId)->with(['user', 'user.user'])->first();
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function personalCapinet(int $chatId): string
    {
        $capitan = '';
        $group = $this->getGroup($chatId);
        foreach ($group->user as $user) {
            if ($user->capitan) {
                $capitan = $user->user->name;
            }
        }
        $text = "👥 <b>Group</b>\n";
        $text .= "Nomi: <b>".$group->name."</b>\n";
        $text .= "Rahbar: <b>".$capitan."</b>\n";
        $text .= "Ishchilar soni: <b>".$group->user->count()."</b>\n";
        $text .= "To’plagan bali: <b>".$group->ball."</b>";
        return $text;
    }

    public function balance(int $chatId): string
    {
        $group = $this->getGroup($chatId);
        $text = "Balans\n";
        $text .= "Guruh : <b>".$group->name."</b>\n";
        $text .= "Ustanovkalar soni: 3\n";
        $text .= "Servislar soni: 4\n";
        return $text;
    }


}
