<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;

it('applies enabled configurables automatically once the application has booted', function () {
    expect(Date::now())->toBeInstanceOf(CarbonImmutable::class);
});
