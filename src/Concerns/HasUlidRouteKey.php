<?php

declare(strict_types=1);

namespace Foxws\Essentials\Concerns;

use Closure;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Keeps the auto-incrementing primary key, and fills a unique "ulid" column that routes
 * bind to, so ids aren't exposed in URLs.
 *
 * @mixin Model
 */
trait HasUlidRouteKey
{
    use HasUlids;

    /**
     * @return list<string>
     */
    public function uniqueIds(): array
    {
        return ['ulid'];
    }

    public function getRouteKeyName(): string
    {
        return 'ulid';
    }

    /**
     * Find a model by its ULID, or return the model as-is when given one. Looks in the
     * route key column, unless another column is given.
     */
    public static function findFromUlid(self|string $value, ?string $column = null): ?static
    {
        if ($value instanceof static) {
            return $value;
        }

        $query = static::query();

        return $query->firstWhere($column ?? $query->getModel()->getRouteKeyName(), $value);
    }

    /**
     * Find a model by its ULID, or call the callback when there is none.
     *
     * @template TValue
     *
     * @param  Closure(): TValue  $callback
     * @return static|TValue
     */
    public static function findFromUlidOr(self|string $value, Closure $callback, ?string $column = null): mixed
    {
        return static::findFromUlid($value, $column) ?? $callback();
    }

    /**
     * Find a model by its ULID, or throw when there is none.
     *
     * @throws ModelNotFoundException<static>
     */
    public static function findFromUlidOrFail(self|string $value, ?string $column = null): static
    {
        return static::findFromUlid($value, $column)
            ?? throw (new ModelNotFoundException)->setModel(static::class, [(string) $value]);
    }
}
