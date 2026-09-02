<?php

declare(strict_types=1);

namespace Foxws\Essentials\Configurables;

use Foxws\Essentials\Contracts\Configurable;
use Illuminate\Database\Eloquent\Model;

final readonly class AutomaticallyEagerLoadRelationships implements Configurable
{
    public function enabled(): bool
    {
        return true;
    }

    public function configure(): void
    {
        Model::automaticallyEagerLoadRelationships();
    }
}
