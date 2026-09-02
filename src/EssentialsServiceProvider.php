<?php

declare(strict_types=1);

namespace Foxws\Essentials;

use Illuminate\Support\ServiceProvider;

class EssentialsServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/essentials.php', 'essentials');

        $this->app->singleton(Essentials::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/essentials.php');

        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'essentials');

        $this->loadTranslationsFrom(__DIR__.'/../lang', 'essentials');

        $this->app->booted(function (): void {
            $this->app->make(Essentials::class)->configure();
        });

        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__.'/../config/essentials.php' => config_path('essentials.php'),
        ], ['essentials', 'essentials-config']);

        // $this->publishes([
        //     __DIR__.'/../resources/views' => resource_path('views/vendor/essentials'),
        // ], ['essentials', 'essentials-views']);

        $this->publishes([
            __DIR__.'/../lang' => $this->app->langPath('vendor/essentials'),
        ], ['essentials', 'essentials-lang']);

        // $this->publishes([
        //     __DIR__.'/../public' => public_path('vendor/essentials'),
        // ], ['essentials', 'essentials-assets']);

        // $this->publishesMigrations([
        //     __DIR__.'/../database/migrations' => database_path('migrations'),
        // ], ['essentials', 'essentials-migrations']);
    }
}
