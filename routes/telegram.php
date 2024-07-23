<?php
///** @var SergiX44\Nutgram\Nutgram $bot */

use App\Telegram\Command\StartCommand;
use App\Telegram\Command\WebHookCommand;
use Illuminate\Support\Facades\Route;
use SergiX44\Nutgram\Nutgram;

/*
|--------------------------------------------------------------------------
| Nutgram Handlers
|--------------------------------------------------------------------------
|
| Here is where you can register telegram handlers for Nutgram. These
| handlers are loaded by the Nutgram ServiceProvider. Enjoy!
|
*/

Route::get('/webhook', [WebHookCommand::class, '__invoke']);

Route::get('/start', [StartCommand::class, 'start']);
