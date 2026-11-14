---
section: Usage
order: 3
---

# Casts, concerns and contracts

## AsDateTime

`Foxws\Essentials\Casts\AsDateTime` stores a date as a date-time string in `app.timezone`, whatever timezone it was given in, and reads blank values as `null`. Dates come from the `Date` factory, so they're immutable when `ImmutableDates` runs.

Laravel's own `datetime` and `immutable_datetime` casts keep the clock time and drop the offset. With `app.timezone` set to `Europe/Amsterdam`:

| Value | `immutable_datetime` stores | `AsDateTime` stores |
| --- | --- | --- |
| `'2026-01-01 12:00:00+00:00'` | `2026-01-01 12:00:00` | `2026-01-01 13:00:00` |
| `''` | `''` | `null` |

That matters for ISO strings from an API, or dates in a user's timezone. Values from `now()` are already in the app timezone either way.

```php
protected function casts(): array
{
    return [
        'published_at' => AsDateTime::class,
    ];
}
```

## HasUlidRouteKey

`Foxws\Essentials\Concerns\HasUlidRouteKey` keeps a model's auto-incrementing primary key, and fills a unique `ulid` column that route model binding uses, so ids aren't exposed in URLs.

```php
use Foxws\Essentials\Concerns\HasUlidRouteKey;

class Invoice extends Model
{
    use HasUlidRouteKey;
}
```

```php
Schema::create('invoices', function (Blueprint $table) {
    $table->id();
    $table->ulid('ulid')->unique();
    // ...
});
```

`Invoice::findFromUlid($ulid)` finds a model by its ULID, and returns the model as-is when you pass one. Like Eloquent's `findOr()` and `findOrFail()`, there's a version that calls a callback and one that throws a `ModelNotFoundException` when no model has the ULID:

```php
Invoice::findFromUlidOr($ulid, fn () => abort(404));
Invoice::findFromUlidOrFail($ulid);
```

A value that isn't a valid ULID finds nothing without querying the database, like route model binding does. They look in the route key column (`ulid`), so overriding `getRouteKeyName()` changes where they look too. Pass a column to look somewhere else:

```php
Invoice::findFromUlid($ulid, 'public_id');
Invoice::findFromUlidOrFail($ulid, 'public_id');
```

To look a ULID up inside a query, such as a relation or with other constraints, use the `whereUlid()` scope. It takes one ULID or a list, and the same optional column. The builder's `first()`, `firstOr()` and `firstOrFail()` work on it as usual:

```php
$customer->invoices()->whereUlid($ulid)->firstOrFail();
Invoice::paid()->whereUlid($ulid)->first();
Invoice::whereUlid([$first, $second])->get();
```

Values that aren't valid ULIDs are left out, so they match nothing.

## Enumerable

`Foxws\Essentials\Contracts\Enumerable` is a backed enum with human-readable labels, e.g. to build select options:

```php
use Foxws\Essentials\Contracts\Enumerable;

enum InvoiceStatus: string implements Enumerable
{
    case Draft = 'draft';
    case Paid = 'paid';

    public function label(): string
    {
        return self::labels()[$this->value];
    }

    public static function labels(): array
    {
        return [
            'draft' => __('Draft'),
            'paid' => __('Paid'),
        ];
    }
}
```

