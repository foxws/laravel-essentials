<?php

declare(strict_types=1);

use Foxws\Essentials\Configurables\ForceRootUrl;
use Illuminate\Support\Facades\Route;

it('builds links on the configured url by default, whatever host or port the request names', function (string $url) {
    Route::get('/links', fn (): string => url('/page'));

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
