<?php
namespace App\Helpers;

use Carbon\Carbon;
use Opcodes\LogViewer\Logs\Log;

class Helper
{
    public static function phoneFormat(string $phone): string
    {
        $kod = substr($phone, 0, 2);
        $prefix = substr($phone, 2, 3);
        $suffix1 = substr($phone, 5, 2);
        $suffix2 = substr($phone, 7,2);

        return "(".$kod.") ".$prefix." - ".$suffix1." - ".$suffix2;
    }


    public static function moneyFormat(string $sum = ''): string
    {
        if ($sum === '')
            return '';

        return number_format( (float) $sum, 0, '.', ' ');
    }



    public static function phoneFormatForTelegram(string $phone): string
    {
        $kod = substr($phone, 0, 2);
        $prefix = substr($phone, 2, 3);
        $suffix1 = substr($phone, 5, 2);
        $suffix2 = substr($phone, 7,2);

        return $kod." ".$prefix." ".$suffix1." ".$suffix2;
    }


}
