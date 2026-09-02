<?php

declare(strict_types=1);

namespace Foxws\Essentials\Configurables;

use Foxws\Essentials\Contracts\Configurable;
use Illuminate\Support\Sleep;

final readonly class FakeSleep implements Configurable
{
    public function enabled(): bool
    {
        return app()->runningUnitTests();
    }

    public function configure(): void
    {
        Sleep::fake();
    }
}
