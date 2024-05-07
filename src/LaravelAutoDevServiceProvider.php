<?php

namespace Laraxot\LaravelAutoDev;

use Illuminate\Support\ServiceProvider;
use Laraxot\LaravelAutoDev\Console\MakeCodeCommand;
use Laraxot\LaravelAutoDev\Console\MakeFabricatorCodeCommand;

class LaravelAutoDevServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/make_code.php', 'make_code');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeCodeCommand::class,
                MakeFabricatorCodeCommand::class,
            ]);

            $this->publishes([
                __DIR__.'/config/make_code.php' => config_path('make_code.php'),
            ]);
        }
    }
}
