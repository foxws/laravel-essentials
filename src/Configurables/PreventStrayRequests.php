<?php

declare(strict_types=1);

namespace Foxws\Essentials\Configurables;

use Foxws\Essentials\Contracts\Configurable;
use Illuminate\Support\Facades\Http;

final readonly class PreventStrayRequests implements Configurable
{
    public function enabled(): bool
    {
        return app()->runningUnitTests();
    }

    public function configure(): void
    {
        Http::preventStrayRequests();
    }
}
