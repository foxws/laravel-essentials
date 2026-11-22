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
        TrustProxies::at($this->getProxies() ?? []);
    }

    /**
     * @return array<int, string>|string|null
     */
    private function getProxies(): array|string|null
    {
        return Config::get('essentials.trusted_proxies');
    }
}
