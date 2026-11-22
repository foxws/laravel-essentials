<?php

declare(strict_types=1);

namespace Foxws\Essentials\Configurables;

use Foxws\Essentials\Contracts\Configurable;
use Illuminate\Http\Middleware\TrustProxies;
use Illuminate\Support\Facades\Config;

/**
 * The withMiddleware() callback in bootstrap/app.php runs before .env and the config are loaded,
 * so proxies that come from either can only be set once the application has booted.
 */
final readonly class SetTrustedProxies implements Configurable
{
    public function enabled(): bool
    {
        return filled($this->getProxies());
    }

    public function configure(): void
    {
        $proxies = $this->getProxies() ?? [];

        TrustProxies::at($proxies === 'auto' ? $this->detectProxies() : $proxies);
    }

    /**
     * Detected on boot rather than in the config, which may be cached where the app is built instead of where it runs.
     * Laravel Cloud's load balancers have no fixed address, so there it's any.
     */
    private function detectProxies(): string
    {
        return laravel_cloud() ? '*' : 'private_ranges';
    }

    /**
     * @return array<int, string>|string|null
     */
    private function getProxies(): array|string|null
    {
        return Config::get('essentials.trusted_proxies');
    }
}
