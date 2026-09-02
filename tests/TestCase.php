<?php

declare(strict_types=1);

namespace Foxws\Essentials\Tests;

use Foxws\Essentials\EssentialsServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            EssentialsServiceProvider::class,
        ];
    }
}
