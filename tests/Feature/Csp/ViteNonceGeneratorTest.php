<?php

declare(strict_types=1);

use Foxws\Essentials\Csp\Nonce\ViteNonceGenerator;
use Illuminate\Support\Facades\Vite;

it('shares the nonce with the tags vite renders', function () {
    $nonce = (new ViteNonceGenerator)->generate();

    expect($nonce)->not->toBeEmpty()
        ->and(Vite::cspNonce())->toBe($nonce);
});
