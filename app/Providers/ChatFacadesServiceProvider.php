<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ChatFacadesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
  		app()->bind('ChatMessages', function () {
            return new \App\Chat\ChatAuth;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
