<?php

namespace Gjae\TelegramLogChannel\Providers;

use Illuminate\Support\ServiceProvider;

class TelegramChannelProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/telegram_channel.php'   => config_path('telegram_channel.php')
        ]);
    }


    public function register()
    {
        
    }
}