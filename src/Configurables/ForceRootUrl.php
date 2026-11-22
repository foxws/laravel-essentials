<?php

declare(strict_types=1);

namespace Foxws\Essentials\Configurables;

use Foxws\Essentials\Contracts\Configurable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

final readonly class ForceRootUrl implements Configurable
{
    public function enabled(): bool
    {
        return ! app()->isLocal() && filled(Config::get('app.url'));
    }

    public function configure(): void
    {
        URL::useOrigin(Config::string('app.url'));
    }
}
