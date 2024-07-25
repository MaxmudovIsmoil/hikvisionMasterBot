<?php
/** @var SergiX44\Nutgram\Nutgram $bot */

use App\Http\Controllers\WebhookController;
use App\Telegram\Command\StartCommand;
use Illuminate\Support\Facades\Route;
use SergiX44\Nutgram\Nutgram;

/*
|--------------------------------------------------------------------------
| Nutgram Handlers
|--------------------------------------------------------------------------
|
| Here is where you can register telegram handlers for Nutgram. These
| handlers are loaded by the NutgramServiceProvider. Enjoy!
|
*/

$bot->onCommand('start', function (Nutgram $bot) {
    return $bot->sendMessage('Hello, world!');
})->description('The start command!');

//Route::post('/webhook', [WebhookController::class, '__invoke']);


Route::get('/start', [StartCommand::class]);


//$bot->onException(function (Nutgram $bot, \Throwable $exception) {
//    \Illuminate\Support\Facades\Log::info($exception->getMessage());
//
//    $chatId = env('ADMIN_CHAT_ID');
//    $bot->sendMessage('Error: ' . $exception->getMessage(), $chatId);
//});
