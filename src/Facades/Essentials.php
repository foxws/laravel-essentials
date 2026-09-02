<?php

declare(strict_types=1);

namespace Foxws\Essentials\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Foxws\Essentials\Essentials
 */
class Essentials extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Foxws\Essentials\Essentials::class;
    }
}
