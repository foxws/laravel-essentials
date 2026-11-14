<?php

declare(strict_types=1);

namespace Foxws\Essentials\Csp\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Spatie\Csp\AddCspHeaders as Middleware;

/**
 * Adds the CSP headers, except on the routes in essentials.csp.except, such as
 * dashboards that ship their own inline scripts.
 */
class AddCspHeaders extends Middleware
{
    public function handle(Request $request, Closure $next, ?string $customPreset = null): mixed
    {
        if ($request->routeIs($this->except())) {
            return $next($request);
        }

        return parent::handle($request, $next, $customPreset);
    }

    /**
     * @return array<int, string>
     */
    protected function except(): array
    {
        return array_values(array_map(strval(...), Config::array('essentials.csp.except', [])));
    }
}
