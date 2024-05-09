<?php

namespace Laraxot\LaravelAutoDev;

use Illuminate\Support\ServiceProvider;
use Laraxot\LaravelAutoDev\Console\AiCodeCommand;
use Laraxot\LaravelAutoDev\Console\MakeCodeCommand;
use Laraxot\LaravelAutoDev\Console\AiFabricatorCommand;
use Laraxot\LaravelAutoDev\Console\AiProjectCommand;
use Laraxot\LaravelAutoDev\Console\MakeFabricatorCodeCommand;

class LaravelAutoDevServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/laravel_auto_dev.php', 'laravel_auto_dev');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                AiCodeCommand::class,
                AiFabricatorCommand::class,
                AiProjectCommand::class
            ]);

            $this->publishes([
                __DIR__.'/config/laravel_auto_dev.php' => config_path('laravel_auto_dev.php'),
            ]);
        }
    }
}
