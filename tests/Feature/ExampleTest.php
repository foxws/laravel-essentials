<?php

declare(strict_types=1);

use Foxws\Essentials\Essentials;

it('resolves the singleton', function () {
    expect(app(Essentials::class))->toBeInstanceOf(Essentials::class);
});

it('returns the same instance from the container', function () {
    expect(app(Essentials::class))->toBe(app(Essentials::class));
});

it('merges the package config', function () {
    expect(config('essentials.layers.Domain.namespace'))->toBe('Domain');
});

it('loads the package translations', function () {
    expect(trans('essentials::messages.placeholder'))->toBe('Essentials placeholder translation.');
});

it('loads the package views', function () {
    expect(view()->exists('essentials::placeholder'))->toBeTrue();
});
