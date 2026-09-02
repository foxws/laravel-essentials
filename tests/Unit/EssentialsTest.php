<?php

declare(strict_types=1);

use Foxws\Essentials\Contracts\Configurable;
use Foxws\Essentials\Essentials;

afterEach(function () {
    Essentials::flushExtendedConfigurables();
});

it('resolves configurables registered via extend() alongside the config ones', function () {
    $spy = new class implements Configurable
    {
        public bool $ran = false;

        public function enabled(): bool
        {
            return true;
        }

        public function configure(): void
        {
            $this->ran = true;
        }
    };

    Essentials::extend($spy);

    (new Essentials(app()))->configure();

    expect($spy->ran)->toBeTrue();
});

it('does not run a configurable whose enabled() returns false', function () {
    $spy = new class implements Configurable
    {
        public bool $ran = false;

        public function enabled(): bool
        {
            return false;
        }

        public function configure(): void
        {
            $this->ran = true;
        }
    };

    Essentials::extend($spy);

    (new Essentials(app()))->configure();

    expect($spy->ran)->toBeFalse();
});

it('only runs configurables once per instance', function () {
    $spy = new class implements Configurable
    {
        public int $runs = 0;

        public function enabled(): bool
        {
            return true;
        }

        public function configure(): void
        {
            $this->runs++;
        }
    };

    Essentials::extend($spy);

    $essentials = new Essentials(app());
    $essentials->configure();
    $essentials->configure();

    expect($spy->runs)->toBe(1);
});
