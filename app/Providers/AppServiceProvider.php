<?php

namespace App\Providers;

use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Telegram\TelegramDriver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        DriverManager::loadDriver(TelegramDriver::class);
    }
}
