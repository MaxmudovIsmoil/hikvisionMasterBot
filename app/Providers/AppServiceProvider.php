<?php

namespace App\Providers;

use App\Telegram\Helpers\Telegram;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;
use Opcodes\LogViewer\Facades\LogViewer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('telegram-facade', function () {
            return new Telegram();
        });

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
//        LogViewer::auth(function ($request) {
//            return $request->user() && ($request->user()->role === 1);
//        });
    }
}
