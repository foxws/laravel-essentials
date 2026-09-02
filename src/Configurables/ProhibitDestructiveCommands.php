<?php

declare(strict_types=1);

namespace Foxws\Essentials\Configurables;

use Foxws\Essentials\Contracts\Configurable;
use Illuminate\Support\Facades\DB;

final readonly class ProhibitDestructiveCommands implements Configurable
{
    public function enabled(): bool
    {
        return app()->isProduction();
    }

    public function configure(): void
    {
        DB::prohibitDestructiveCommands();
    }
}
