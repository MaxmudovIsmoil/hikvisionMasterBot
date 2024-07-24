<?php
///** @var SergiX44\Nutgram\Nutgram $bot */

use App\Http\Controllers\WebhookController;
use App\Telegram\Command\RunCommand;
use App\Telegram\Command\StartCommand;
use App\Telegram\Command\WebHookCommand;
use Illuminate\Support\Facades\Route;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\RunningMode\Polling;


/*
|--------------------------------------------------------------------------
| Nutgram Handlers
|--------------------------------------------------------------------------
|
| Here is where you can register telegram handlers for Nutgram. These
| handlers are loaded by the Nutgram ServiceProvider. Enjoy!
|
*/

Route::get('/webhook', [WebhookController::class, '__invoke']);


Route::get('/start', [StartCommand::class, 'start']);



//$bot->onException(function (Nutgram $bot, \Throwable $exception) {
//    \Illuminate\Support\Facades\Log::info($exception->getMessage());
//
//    $chatId = env('ADMIN_CHAT_ID');
//    $bot->sendMessage('Error: ' . $exception->getMessage(), $chatId);
//});
