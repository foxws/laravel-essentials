<?php

declare(strict_types=1);

use Foxws\Essentials\Csp\Presets\BasicPreset;
use Foxws\Essentials\Csp\Presets\IconifyPreset;
use Foxws\Essentials\Csp\Presets\ReverbPreset;
use Spatie\Csp\Policy;

it('builds a strict policy scoped to the application host', function () {
    config(['app.url' => 'https://app.example.com']);

    $policy = new Policy;
    (new BasicPreset)->configure($policy);

    expect($policy->getContents())
        ->toContain("default-src 'self'")
        ->toContain("connect-src 'self' blob: https://*.app.example.com wss://*.app.example.com")
        ->toContain("frame-ancestors 'none'")
        ->toContain("object-src 'none'")
        ->toContain("'strict-dynamic'");
});

it('upgrades insecure requests when the app runs on https', function () {
    config(['app.url' => 'https://app.example.com']);

    $policy = new Policy;
    (new BasicPreset)->configure($policy);

    expect($policy->getContents())->toContain('upgrade-insecure-requests');
});

it('leaves requests alone when the app runs on http', function () {
    config(['app.url' => 'http://localhost:8000']);

    $policy = new Policy;
    (new BasicPreset)->configure($policy);

    expect($policy->getContents())->not->toContain('upgrade-insecure-requests');
});

it('allows the iconify api', function () {
    $policy = new Policy;
    (new IconifyPreset)->configure($policy);

    expect($policy->getContents())->toContain('connect-src api.iconify.design');
});

it('allows websocket connections to reverb', function (string $scheme, int|string $port, string $origin) {
    config([
        'reverb.apps.apps.0.options.wsHost' => 'ws.example.test',
        'reverb.apps.apps.0.options.wsPort' => $port,
        'reverb.apps.apps.0.options.wsScheme' => $scheme,
    ]);

    $policy = new Policy;
    (new ReverbPreset)->configure($policy);

    expect($policy->getContents())->toBe("connect-src {$origin}");
})->with([
    'secure on the default port' => ['https', 443, 'wss://ws.example.test'],
    'plain on its own port' => ['http', 8080, 'ws://ws.example.test:8080'],
    'port from an env string' => ['https', '8443', 'wss://ws.example.test:8443'],
]);

it('falls back to the reverb server options', function () {
    config([
        'reverb.apps.apps.0.options.host' => 'reverb.example.test',
        'reverb.apps.apps.0.options.port' => 8080,
        'reverb.apps.apps.0.options.scheme' => 'http',
    ]);

    $policy = new Policy;
    (new ReverbPreset)->configure($policy);

    expect($policy->getContents())->toBe('connect-src ws://reverb.example.test:8080');
});

it('adds no reverb origin when no host is configured', function () {
    config(['reverb.apps.apps.0.options' => ['wsHost' => '', 'host' => null]]);

    $policy = new Policy;
    (new ReverbPreset)->configure($policy);

    expect($policy->getContents())->toBe('');
});
