<?php

declare(strict_types=1);

use Foxws\Essentials\Configurables\ForceRootUrl;
use Foxws\Essentials\Essentials;
use Illuminate\Support\Facades\Route;

beforeEach(function () {
    Route::get('/links', fn (): string => url('/page'));
});

it('leaves links on the request\'s host and port by default', function (string $url, string $link) {
    $this->get($url)->assertContent($link);
})->with([
    'another host' => ['http://other.test/links', 'https://other.test/page'],
    'another port' => ['http://localhost:1337/links', 'https://localhost:1337/page'],
]);

it('builds links on the configured url once added, whatever host or port the request names', function (string $url) {
    config(['essentials.configurables' => [ForceRootUrl::class]]);

    (new Essentials(app()))->configure();

    $this->get($url)->assertContent('https://localhost/page');
})->with([
    'another host' => 'http://other.test/links',
    'another port' => 'http://localhost:1337/links',
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
