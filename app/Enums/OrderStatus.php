<?php

namespace App\Enums;

enum OrderStatus: int
{
    case adminNew = 1; // admin yangi order qo'shdi
    case groupAccepted = 2; // guruh orderni qabul qilib oldi
    case groupRunning = 3; // guruh orderni bajarmoqda
    case groupClosingProcess = 4; // guruh orderni yopish jarayonida
    case groupClosedSuccessfully = 5; // guruh orderni muvaffaqiyatli yopdi
    case groupPostponed = 6; // guruh orderni keyinga qoldirildi
    case adminPostponed = 7; // admin orderni keyinga qoldirildi
    case adminStopped = 8; // admin orderni to'xtatdi

    public static function toArray(): array
    {
        return [
            self::adminNew->value,
            self::groupAccepted->value,
            self::groupRunning->value,
            self::groupClosingProcess->value,
            self::groupClosedSuccessfully->value,
            self::groupPostponed->value,
            self::adminPostponed->value,
            self::adminStopped->value
        ];
    }
    public function getLabelText(): string
    {
        return match ($this) {
            self::adminNew => 'yangi',
            self::groupAccepted => 'Qabul qilindi',
            self::groupRunning => 'Bajarilmoqda',
            self::groupClosingProcess => 'Yopilish jarajonida',
            self::groupClosedSuccessfully => 'Yopildi',
            self::groupPostponed => 'Keyinga qoldirildi',
            self::adminPostponed => 'Keyinga qoldirildi',
            self::adminStopped => 'To\'xtatildi',
        };
    }

    public function isAdminNew(): bool
    {
        return $this === self::adminNew;
    }
    public function isGroupAccepted(): bool
    {
        return  $this === self::groupAccepted;
    }
    public function isGroupRunning(): bool
    {
        return  $this === self::groupRunning;
    }
    public function isGroupClosingProcess(): bool
    {
        return  $this === self::groupClosingProcess;
    }
    public function isGroupClosedSuccessfully(): bool
    {
        return $this === self::groupClosedSuccessfully;
    }
    public function isGroupPostponed(): bool
    {
        return  $this === self::groupPostponed;
    }
    public function isAdminPostponed(): bool
    {
        return  $this === self::adminPostponed;
    }
    public function isAdminStopped(): bool
    {
        return  $this === self::adminStopped;
    }


    public function getCssClass(): string
    {
        $statusClassMap = [
            'isAdminNew' => 'bg-warning',
            'isGroupAccepted' => 'bg-primary',
            'isGroupRunning' => 'bg-info',
            'isGroupClosingProcess' => 'bg-info',
            'isGroupClosedSuccessfully' => 'bg-success',
            'isGroupPostponed' => 'bg-danger',
            'isAdminPostponed' => 'bg-danger',
            'isAdminStopped' => 'bg-secondary',
        ];

        foreach ($statusClassMap as $method => $cssClass) {
            if ($this->{$method}()) {
                return $cssClass;
            }
        }

        return ''; // Default class if no status matches
    }
}
