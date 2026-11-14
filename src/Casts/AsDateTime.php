<?php

declare(strict_types=1);

namespace Foxws\Essentials\Casts;

use Carbon\CarbonInterface;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Date;

/**
 * Stores dates as a date-time string in the app timezone, whatever timezone they were given in,
 * and reads blank values as null. Dates come from the Date factory, so ImmutableDates applies.
 *
 * @implements CastsAttributes<CarbonInterface|null, mixed>
 */
class AsDateTime implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): ?CarbonInterface
    {
        if (blank($value)) {
            return null;
        }

        return Date::parse($value);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        if (blank($value)) {
            return null;
        }

        return Date::parse($value)
            ->setTimezone(Config::string('app.timezone', 'UTC'))
            ->toDateTimeString();
    }
}
