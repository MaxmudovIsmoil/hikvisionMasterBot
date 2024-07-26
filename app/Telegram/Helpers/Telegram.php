<?php

namespace App\Telegram\Helpers;

use App\Models\User;
use Illuminate\Support\Str;
use Opcodes\LogViewer\Logs\Log;

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
        return User::where('chatId', $chatId)->doesntExist();
    }

    public function checkUserId(int $chatId): ?int
    {
        $user = User::where('chatId', $chatId)->first();

        return $user?->id;
    }


    public function checkPhoneAndGetUser(string $phone, int $chatId): ?User
    {
        if (strlen($phone) > 9) {
            $phone = substr($phone, -9);
        }
        $user = User::where('phone', $phone)->with('group.group')->first();

        if ($user) {
            $user->update(['chatId' => $chatId]);
            return $user;
        }
        return null;
    }


    public function getUser(int $chatId): object|string
    {
        try {
            return User::where('chatId', $chatId)->with('group.group')->first();
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function personalCapinet(int $chatId): string
    {
        $user = $this->getUser($chatId);
        $text = 'Guruh nomi: '.$user->group->group->name;
        $text .= 'Guruhdagi ishchilar soni: '.$user->group->group->name;
        $text .= 'Guruh to’plagan bali: '.$user->group->group->ball;
        return $text;
    }

}
