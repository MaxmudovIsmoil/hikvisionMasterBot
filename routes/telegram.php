<?php
/** @var SergiX44\Nutgram\Nutgram $bot */


use App\Http\Controllers\WebhookController;
use App\Telegram\Command\StartCommand;
use Nutgram\Laravel\Facades\Telegram;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Nutgram Handlers
|--------------------------------------------------------------------------
|
| Here is where you can register telegram handlers for Nutgram. These
| handlers are loaded by the NutgramServiceProvider. Enjoy!
|
*/

Route::post('/webhook', [WebhookController::class, '__invoke']);


Route::get('/start', [StartCommand::class]);

//Telegram::onCommand('start', function () {
//    Telegram::sendMessage('Hello, world!');
//});
//
//$bot->onException(function (Nutgram $bot, \Throwable $exception) {
//    \Illuminate\Support\Facades\Log::info($exception->getMessage());
//
//    $chatId = env('ADMIN_CHAT_ID');
//    $bot->sendMessage('Error: ' . $exception->getMessage(), $chatId);
//});
