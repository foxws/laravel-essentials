<?php

declare(strict_types=1);

use Foxws\Essentials\Configurables\ForceHttpsScheme;

it('is enabled in production', function () {
    app()->detectEnvironment(fn (): string => 'production');

    expect((new ForceHttpsScheme)->enabled())->toBeTrue();
});

it('is disabled outside production', function (string $environment) {
    app()->detectEnvironment(fn (): string => $environment);

    expect((new ForceHttpsScheme)->enabled())->toBeFalse();
})->with([
    'local' => 'local',
    'staging' => 'staging',
    'testing' => 'testing',
]);
