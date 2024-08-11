<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use Nutgram\Laravel\Facades\Telegram;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Response::macro('success', function ($data = null, $code = 200) {
            return response()->json([
                'success'  => true,
                'data' => $data,
            ], $code);
        });

        Response::macro('fail', function ($error, $code = 400) {
//            $chatId = config('nutgram.adminChatId');
//            Telegram::sendMessage('Error: '.$error, $chatId);
            return response()->json([
                'success'  => false,
                'error' => $error,
            ], $code);
        });
    }
}
