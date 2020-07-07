<?php

namespace Helldar\LaravelIdeFacadesHelper;

use Helldar\LaravelIdeFacadesHelper\Commands\Generate;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

final class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $this->bootCommands();
        $this->bootPublishes();
        $this->bootViews();
    }

    public function register()
    {
        $this->registerConfig();
    }

    protected function bootCommands(): void
    {
        $this->commands([
            Generate::class,
        ]);
    }

    protected function bootPublishes(): void
    {
        $this->publishes([
            __DIR__ . '/../config/ide-helper.php' => $this->app->configPath('ide-helper.php'),
        ], 'config');
    }

    protected function bootViews(): void
    {
        $this->loadViewsFrom(
            __DIR__ . '/../resources/views', 'laravel-ide-facades-helper'
        );
    }

    protected function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/ide-helper.php', 'ide-helper');
    }
}
