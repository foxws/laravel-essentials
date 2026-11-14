<?php

declare(strict_types=1);

use Foxws\Essentials\Csp\Middleware\AddCspHeaders;
use Foxws\Essentials\Csp\Nonce\ViteNonceGenerator;
use Foxws\Essentials\Csp\Presets\BasicPreset;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Vite;

beforeEach(function () {
    config(['csp.presets' => [BasicPreset::class]]);

    Route::middleware(AddCspHeaders::class)->group(function () {
        Route::get('/page', fn () => 'page')->name('page');
        Route::get('/horizon', fn () => 'dashboard')->name('horizon.index');
    });
});

it('adds the csp header', function () {
    $response = $this->get('/page')->assertOk();

    expect($response->headers->get('Content-Security-Policy'))
        ->toContain("default-src 'self'")
        ->toContain("'nonce-".app('csp-nonce')."'");
});

it('shares the nonce with the tags vite renders', function () {
    $nonce = (new ViteNonceGenerator)->generate();

    expect($nonce)->not->toBeEmpty()
        ->and(Vite::cspNonce())->toBe($nonce);
});

it('skips the routes in essentials.csp.except', function () {
    $this->get('/horizon')
        ->assertOk()
        ->assertHeaderMissing('Content-Security-Policy');
});
