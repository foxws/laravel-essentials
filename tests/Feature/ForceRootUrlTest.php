<?php

declare(strict_types=1);

use Foxws\Essentials\Configurables\ForceRootUrl;
use Foxws\Essentials\Essentials;
use Illuminate\Support\Facades\Route;

beforeEach(function () {
    config(['app.url' => 'http://example.com']);

    Route::get('/links', fn (): string => url('/page'));
});

it('leaves the root url to the request by default', function () {
    $this->get('http://other.test:1337/links')
        ->assertContent('https://other.test:1337/page');
});

it('builds links on the configured url, whatever host or port the request names', function (string $url) {
    config(['essentials.configurables' => [ForceRootUrl::class]]);

    (new Essentials(app()))->configure();

    $this->get($url)->assertContent('https://example.com/page');
})->with([
    'another host' => 'http://other.test/links',
    'another port' => 'http://example.com:1337/links',
]);

it('is disabled locally', function () {
    app()->detectEnvironment(fn (): string => 'local');

    expect((new ForceRootUrl)->enabled())->toBeFalse();
});

it('is disabled without a configured url', function (?string $url) {
    config(['app.url' => $url]);

    expect((new ForceRootUrl)->enabled())->toBeFalse();
})->with([
    'null' => [null],
    'empty' => [''],
]);
