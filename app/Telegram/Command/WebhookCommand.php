<?php

namespace App\Telegram\Command;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use SergiX44\Nutgram\Nutgram;

class WebhookCommand extends Controller
{
    public function __invoke()
    {
        $api = config('telegram.api');
        $token = config('telegram.token');
        $url = config('app.url');
        $http = Http::get($api.$token.'/setWebhook?url='.$url.'/start');
        dd($http->body());
    }
}
