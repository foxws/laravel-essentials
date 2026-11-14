<?php

declare(strict_types=1);

namespace Foxws\Essentials\Csp\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Telescope\Telescope;
use Symfony\Component\HttpFoundation\Response;

/**
 * Gives the Telescope dashboard the request's CSP nonce. Add it to telescope.middleware.
 */
class AddTelescopeCspNonce
{
    public function handle(Request $request, Closure $next): Response
    {
        if (class_exists(Telescope::class) && app()->bound('csp-nonce')) {
            Telescope::cspNonce(app('csp-nonce'));
        }

        return $next($request);
    }
}
