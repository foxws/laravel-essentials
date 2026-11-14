<?php

declare(strict_types=1);

namespace Foxws\Essentials\Csp\Nonce;

use Illuminate\Support\Facades\Vite;
use Spatie\Csp\Nonce\NonceGenerator;

/**
 * Shares one nonce between the CSP header and the tags Vite renders.
 */
class ViteNonceGenerator implements NonceGenerator
{
    public function generate(): string
    {
        return Vite::useCspNonce();
    }
}
