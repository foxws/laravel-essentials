<?php

declare(strict_types=1);

namespace Foxws\Essentials;

use Foxws\Essentials\Contracts\Configurable;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Collection;

class Essentials
{
    /**
     * Configurables registered at runtime, in addition to the ones in config('essentials.configurables').
     *
     * @var array<int, class-string<Configurable>|Configurable>
     */
    protected static array $configurables = [];

    protected bool $configured = false;

    public function __construct(protected Container $container) {}

    /**
     * Register an additional configurable, e.g. from another package or the application's own service provider.
     *
     * @param  class-string<Configurable>|Configurable  $configurable
     */
    public static function extend(string|Configurable $configurable): void
    {
        static::$configurables[] = $configurable;
    }

    /**
     * Remove any configurables registered at runtime via extend(). Intended for resetting state between tests.
     */
    public static function flushExtendedConfigurables(): void
    {
        static::$configurables = [];
    }

    /**
     * Resolve every configurable and run the ones that are enabled.
     *
     * Safe to call more than once: the work only happens on the first call.
     */
    public function configure(): void
    {
        if ($this->configured) {
            return;
        }

        $this->configured = true;

        $this->configurables()
            ->filter(fn (Configurable $configurable) => $configurable->enabled())
            ->each(fn (Configurable $configurable) => $configurable->configure());
    }

    /**
     * The resolved configurable instances from config and runtime registrations.
     *
     * @return Collection<int, Configurable>
     */
    public function configurables(): Collection
    {
        /** @var array<int, class-string<Configurable>|Configurable> $configurables */
        $configurables = array_merge(
            (array) config('essentials.configurables', []),
            static::$configurables,
        );

        return Collection::make($configurables)
            ->map(fn (string|Configurable $configurable) => is_string($configurable)
                ? $this->container->make($configurable)
                : $configurable,
            );
    }
}
