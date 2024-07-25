<?php
/** @var SergiX44\Nutgram\Nutgram $bot */


use Nutgram\Laravel\Facades\Telegram;

/*
|--------------------------------------------------------------------------
| Nutgram Handlers
|--------------------------------------------------------------------------
|
| Here is where you can register telegram handlers for Nutgram. These
| handlers are loaded by the NutgramServiceProvider. Enjoy!
|
*/

//$bot->onCommand('start', function (Nutgram $bot) {
//    return $bot->sendMessage('Hello, world!');
//})->description('The start command!');

//Route::post('/webhook', [WebhookController::class, '__invoke']);


//Route::get('/start', [StartCommand::class]);

Telegram::onCommand('start', function () {
    Telegram::sendMessage('Hello, world!');
});

//$bot->onException(function (Nutgram $bot, \Throwable $exception) {
//    \Illuminate\Support\Facades\Log::info($exception->getMessage());
//
//    $chatId = env('ADMIN_CHAT_ID');
//    $bot->sendMessage('Error: ' . $exception->getMessage(), $chatId);
//});
