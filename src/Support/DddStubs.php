<?php

declare(strict_types=1);

namespace Foxws\Essentials\Support;

use Illuminate\Support\Facades\Config;

class DddStubs
{
    /**
     * Get the configured stub path overrides, keyed by type.
     *
     * @return array<string, string>
     */
    public static function get(): array
    {
        return Config::array('essentials.ddd_stubs', []);
    }
}
