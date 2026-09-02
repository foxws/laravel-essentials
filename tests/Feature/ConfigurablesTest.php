<?php

declare(strict_types=1);

use Illuminate\Support\Facades\URL;

it('applies enabled configurables automatically once the application has booted', function () {
    expect(URL::to('/'))->toStartWith('https://');
});
