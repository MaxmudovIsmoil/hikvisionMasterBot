<?php

namespace App\Enums;

enum UserRole: int
{
    case admin = 1;
    case user = 2;
    case master = 3;

    public static function toArray(): array
    {
        return [
            self::admin->value,
            self::user->value,
            self::master->value,
        ];
    }


    public function isAdmin(): bool
    {
        return $this === self::admin;
    }
    public function isUser(): bool
    {
        return  $this === self::user;
    }
    public function isMaster(): bool
    {
        return  $this === self::master;
    }

}
