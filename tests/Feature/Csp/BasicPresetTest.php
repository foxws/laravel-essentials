<?php

declare(strict_types=1);

use Foxws\Essentials\Csp\Presets\BasicPreset;
use Foxws\Essentials\Csp\Presets\IconifyPreset;
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
