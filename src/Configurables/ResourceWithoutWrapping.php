<?php

declare(strict_types=1);

namespace Foxws\Essentials\Configurables;

use Foxws\Essentials\Contracts\Configurable;
use Illuminate\Http\Resources\Json\JsonResource;

final readonly class ResourceWithoutWrapping implements Configurable
{
    public function enabled(): bool
    {
        return true;
    }

    public function configure(): void
    {
        JsonResource::withoutWrapping();
    }
}
