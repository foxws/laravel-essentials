<?php

declare(strict_types=1);

namespace Essentials\Essentials\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Essentials\Essentials\Essentials
 */
class Essentials extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Essentials\Essentials\Essentials::class;
    }
}
