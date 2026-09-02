<?php

declare(strict_types=1);

namespace Foxws\Essentials\Configurables;

use Foxws\Essentials\Contracts\Configurable;
use Illuminate\Validation\Rules\Password;

final readonly class UseSecurePassword implements Configurable
{
    public function enabled(): bool
    {
        return app()->isProduction();
    }

    public function configure(): void
    {
        Password::defaults(fn (): ?Password => Password::min(12)
            ->max(24)
            ->letters()
            ->mixedCase()
            ->numbers()
            ->symbols()
            ->uncompromised(),
        );
    }
}
