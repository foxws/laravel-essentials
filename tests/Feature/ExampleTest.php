<?php

declare(strict_types=1);

use Essentials\Essentials\Essentials;

it('resolves the singleton', function () {
    expect(app(Essentials::class))->toBeInstanceOf(Essentials::class);
});

it('returns the same instance from the container', function () {
    expect(app(Essentials::class))->toBe(app(Essentials::class));
});

it('merges the package config', function () {
    expect(config('laravel-essentials.placeholder'))->toBe('default');
});

it('loads the package translations', function () {
    expect(trans('laravel-essentials::messages.placeholder'))->toBe('Essentials placeholder translation.');
});

it('loads the package views', function () {
    expect(view()->exists('laravel-essentials::placeholder'))->toBeTrue();
});

it('registers the artisan command', function () {
    $this->artisan('laravel-essentials:placeholder')
        ->expectsOutputToContain('Essentials placeholder command executed.')
        ->assertSuccessful();
});
