<?php

declare(strict_types=1);

namespace Foxws\Essentials\Configurables;

use Foxws\Essentials\Contracts\Configurable;
use Illuminate\Support\Facades\URL;

final readonly class ForceHttpsScheme implements Configurable
{
    public function enabled(): bool
    {
        return app()->isProduction();
    }

    public function configure(): void
    {
        URL::forceHttps();
    }
}
