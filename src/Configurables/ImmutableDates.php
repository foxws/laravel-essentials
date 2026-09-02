<?php

declare(strict_types=1);

namespace Foxws\Essentials\Configurables;

use Carbon\CarbonImmutable;
use Foxws\Essentials\Contracts\Configurable;
use Illuminate\Support\Facades\Date;

final readonly class ImmutableDates implements Configurable
{
    public function enabled(): bool
    {
        return true;
    }

    public function configure(): void
    {
        Date::use(CarbonImmutable::class);
    }
}
