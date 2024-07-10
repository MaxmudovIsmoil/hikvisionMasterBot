<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class TelegramController extends Controller
{
    public function test()
    {
//        return phpinfo();

        $client = new Client([
            'verify' => 'D:\php-8.3.7\cacert.pem',
        ]);
        $token = config('telegram.token');
        $response = $client->get('https://api.telegram.org/bot'.$token.'/getUpdates');
        dd($response);
    }
}
