<?php

declare(strict_types=1);

namespace Foxws\Essentials\Csp\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Horizon\Horizon;
use Symfony\Component\HttpFoundation\Response;

/**
 * Gives the Horizon dashboard the request's CSP nonce, so its inline style and script tags
 * pass the app's policy. Add it to horizon.middleware.
 */
class AddHorizonCspNonce
{
    public function handle(Request $request, Closure $next): Response
    {
        if (class_exists(Horizon::class) && app()->bound('csp-nonce')) {
            Horizon::cspNonce(app('csp-nonce'));
        }

        return $next($request);
    }
}
