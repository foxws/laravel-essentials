<?php

declare(strict_types=1);

namespace Foxws\Essentials\Concerns;

use BackedEnum;

/**
 * Builds labels() from each case's label(), for enums that implement Enumerable. This is
 * the shape spatie/laravel-options reads in Options::forEnum().
 *
 * @mixin BackedEnum
 */
trait HasLabels
{
    /**
     * The labels of every case, keyed by value.
     *
     * @return array<int|string, string>
     */
    public static function labels(): array
    {
        $labels = [];

        foreach (self::cases() as $case) {
            $labels[$case->value] = $case->label();
        }

        return $labels;
    }
}
