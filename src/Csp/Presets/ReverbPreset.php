<?php

declare(strict_types=1);

namespace Foxws\Essentials\Csp\Presets;

use Illuminate\Support\Facades\Config;
use Spatie\Csp\Directive;
use Spatie\Csp\Policy;
use Spatie\Csp\Preset;

/**
 * Lets Echo connect to Reverb, which usually runs on its own port or host and isn't covered
 * by "self" or the app's subdomains. Reads where browsers reach Reverb from the first app's
 * wsHost, wsPort and wsScheme options, falling back to its host, port and scheme.
 */
class ReverbPreset implements Preset
{
    public function configure(Policy $policy): void
    {
        if ($origin = $this->origin()) {
            $policy->add(Directive::CONNECT, $origin);
        }
    }

    protected function origin(): ?string
    {
        $host = (string) $this->option('wsHost', 'host');

        if ($host === '') {
            return null;
        }

        $isSecure = ((string) ($this->option('wsScheme', 'scheme') ?: 'https')) === 'https';
        $defaultPort = $isSecure ? 443 : 80;
        $port = (int) ($this->option('wsPort', 'port') ?: $defaultPort);

        $scheme = $isSecure ? 'wss' : 'ws';

        return $port === $defaultPort
            ? "{$scheme}://{$host}"
            : "{$scheme}://{$host}:{$port}";
    }

    protected function option(string $browserKey, string $serverKey): mixed
    {
        return Config::get("reverb.apps.apps.0.options.{$browserKey}")
            ?: Config::get("reverb.apps.apps.0.options.{$serverKey}");
    }
}
