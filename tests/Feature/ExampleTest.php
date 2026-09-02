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
    expect(config('essentials.morph_map'))->toBe([]);
});

it('loads the package translations', function () {
    expect(trans('essentials::messages.placeholder'))->toBe('Essentials placeholder translation.');
});
