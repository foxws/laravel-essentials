<?php

declare(strict_types=1);

namespace Foxws\Essentials\Configurables;

use Foxws\Essentials\Contracts\Configurable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Config;

final readonly class EnforceMorphMap implements Configurable
{
    public function enabled(): bool
    {
        return filled($this->getMorphMap());
    }

    public function configure(): void
    {
        Relation::enforceMorphMap(
            $this->getMorphMap(),
        );
    }

    /**
     * @return array<string, class-string<Model>>
     */
    private function getMorphMap(): array
    {
        return Config::get('essentials.morph_map', []);
    }
}
