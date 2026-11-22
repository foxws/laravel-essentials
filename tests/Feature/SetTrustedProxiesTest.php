<?php

declare(strict_types=1);

use Foxws\Essentials\Configurables\SetTrustedProxies;
use Foxws\Essentials\Essentials;
use Illuminate\Http\Middleware\TrustProxies;
use Illuminate\Support\Facades\Route;

beforeEach(function () {
    Route::get('/client', fn (): string => (string) request()->ip());
});

it('trusts the configured proxies', function (string|array $proxies, string $remote, string $ip) {
    config(['essentials.trusted_proxies' => $proxies]);

    (new Essentials(app()))->configure();

    $this->withServerVariables(['REMOTE_ADDR' => $remote])
        ->get('/client', ['X-Forwarded-For' => '198.51.100.7'])
        ->assertContent($ip);
})->with([
    'a private proxy' => ['private_ranges', '10.89.0.5', '198.51.100.7'],
    'a client outside the private ranges' => ['private_ranges', '203.0.113.9', '203.0.113.9'],
    'a comma-separated list' => ['192.0.2.1, 203.0.113.0/24', '203.0.113.9', '198.51.100.7'],
    'an array' => [['203.0.113.9'], '203.0.113.9', '198.51.100.7'],
]);

it('leaves the proxies of the app alone without configured ones', function (string|array|null $proxies) {
    TrustProxies::at('203.0.113.9');
    config(['essentials.trusted_proxies' => $proxies]);

    (new Essentials(app()))->configure();

    expect((new SetTrustedProxies)->enabled())->toBeFalse();

    $this->withServerVariables(['REMOTE_ADDR' => '203.0.113.9'])
        ->get('/client', ['X-Forwarded-For' => '198.51.100.7'])
        ->assertContent('198.51.100.7');
})->with([
    'null' => [null],
    'empty string' => [''],
    'empty array' => [[]],
]);
