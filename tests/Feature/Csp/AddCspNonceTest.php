<?php

declare(strict_types=1);

use Foxws\Essentials\Csp\Middleware\AddHorizonCspNonce;
use Foxws\Essentials\Csp\Middleware\AddTelescopeCspNonce;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

it('passes the request through when horizon and telescope are not installed', function (string $middleware) {
    $response = app($middleware)->handle(Request::create('/'), fn () => new Response('dashboard'));

    expect($response->getContent())->toBe('dashboard');
})->with([
    AddHorizonCspNonce::class,
    AddTelescopeCspNonce::class,
]);
