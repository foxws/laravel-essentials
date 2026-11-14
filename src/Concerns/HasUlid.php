<?php

declare(strict_types=1);

namespace Foxws\Essentials\Concerns;

use Closure;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

/**
 * Keeps the auto-incrementing primary key, and fills a unique "ulid" column to expose instead
 * of the id, e.g. with #[RouteKey('ulid')] on the model so routes bind to it.
 *
 * @mixin Model
 */
trait HasUlid
{
    use HasUlids;

    /**
     * @return list<string>
     */
    public function uniqueIds(): array
    {
        return ['ulid'];
    }

    /**
     * Find a model by its ULID, or return the model as-is when given one. Looks in the
     * "ulid" column, unless another column is given. A value that isn't a valid ULID
     * finds nothing without querying, like route model binding.
     */
    public static function findFromUlid(self|string $value, ?string $column = null): ?static
    {
        if ($value instanceof static) {
            return $value;
        }

        if (! Str::isUlid($value)) {
            return null;
        }

        return static::query()->whereUlid($value, $column)->first();
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

    /**
     * Constrain the query to the given ULIDs, e.g. $user->posts()->whereUlid($ulid)->firstOrFail().
     * Looks in the "ulid" column, unless another column is given. Values that aren't
     * valid ULIDs are left out, so they match nothing.
     *
     * @param  Builder<static>  $query
     * @param  string|array<int, string>  $ulids
     */
    #[Scope]
    protected function whereUlid(Builder $query, string|array $ulids, ?string $column = null): void
    {
        $ulids = array_values(array_filter((array) $ulids, Str::isUlid(...)));

        $query->whereIn($query->qualifyColumn($column ?? $this->uniqueIds()[0]), $ulids);
    }
}
