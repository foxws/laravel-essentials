<?php

declare(strict_types=1);

namespace Essentials\Essentials;

use Essentials\Essentials\Console\Commands\EssentialsCommand;
use Illuminate\Support\ServiceProvider;

class EssentialsServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-essentials.php', 'laravel-essentials');

        $this->app->singleton(Essentials::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/laravel-essentials.php');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-essentials');

        $this->loadTranslationsFrom(__DIR__.'/../lang', 'laravel-essentials');

        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__.'/../config/laravel-essentials.php' => config_path('laravel-essentials.php'),
        ], ['laravel-essentials', 'laravel-essentials-config']);

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/laravel-essentials'),
        ], ['laravel-essentials', 'laravel-essentials-views']);

        $this->publishes([
            __DIR__.'/../lang' => $this->app->langPath('vendor/laravel-essentials'),
        ], ['laravel-essentials', 'laravel-essentials-lang']);

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/laravel-essentials'),
        ], ['laravel-essentials', 'laravel-essentials-assets']);

        $this->publishesMigrations([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], ['laravel-essentials', 'laravel-essentials-migrations']);

        $this->commands([
            EssentialsCommand::class,
        ]);
    }
}
