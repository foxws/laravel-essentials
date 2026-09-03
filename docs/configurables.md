# Configurables

Laravel Essentials applies a set of opinionated defaults once your application has booted. Each default is a small class called a "configurable".

## How It Works

Every configurable implements `Foxws\Essentials\Contracts\Configurable`:

```php
use Foxws\Essentials\Contracts\Configurable;

interface Configurable
{
    public function enabled(): bool;

    public function configure(): void;
}
```

After the application boots, `Foxws\Essentials\Essentials::configure()` filters the configured list down to the ones whose `enabled()` returns `true`, then calls `configure()` on each. This happens automatically — you don't need to call anything yourself.

## Built-in Configurables

| Configurable                          | Enabled when                        | What it does                                                                                       |
| ------------------------------------- | ----------------------------------- | -------------------------------------------------------------------------------------------------- |
| `AggressivePrefetching`               | Always                              | `Vite::useAggressivePrefetching()`                                                                 |
| `AutomaticallyEagerLoadRelationships` | Always                              | `Model::automaticallyEagerLoadRelationships()`                                                     |
| `EnforceMorphMap`                     | `essentials.morph_map` is not empty | `Relation::enforceMorphMap(...)`                                                                   |
| `FakeSleep`                           | Running unit tests                  | `Sleep::fake()`                                                                                    |
| `ForceHttpsScheme`                    | Always                              | `URL::forceHttps()`                                                                                |
| `ForceSecurePassword`                 | Running in production               | `Password::defaults()` with a 12–64 char, mixed-case, numbers, symbols, and "uncompromised" policy |
| `ImmutableDates`                      | Always                              | `Date::use(CarbonImmutable::class)`                                                                |
| `ModelShouldBeStrict`                 | Always                              | `Model::shouldBeStrict()`                                                                          |
| `ModelUnguard`                        | Opt-in                              | `Model::unguard()`                                                                                 |
| `PreventStrayRequests`                | Running unit tests                  | `Http::preventStrayRequests()`                                                                     |
| `ProhibitDestructiveCommands`         | Running in production               | `DB::prohibitDestructiveCommands()`                                                                |
| `ResourceWithoutWrapping`             | Always                              | `JsonResource::withoutWrapping()`                                                                  |

Enable, disable, or reorder configurables by publishing the config file and editing the `configurables` array:

```bash
php artisan vendor:publish --tag="laravel-essentials-config"
```

```php
// config/essentials.php
'configurables' => [
    Foxws\Essentials\Configurables\ForceHttpsScheme::class,
    Foxws\Essentials\Configurables\ImmutableDates::class,
    // ...
],
```

## Writing Your Own Configurable

```php
namespace App\Configurables;

use Foxws\Essentials\Contracts\Configurable;
use Illuminate\Support\Facades\Date;

final readonly class UseUtcTimezone implements Configurable
{
    public function enabled(): bool
    {
        return true;
    }

    public function configure(): void
    {
        Date::setTestNow();
    }
}
```

Add it to `config('essentials.configurables')`, or register it at runtime — for example from your own package's service provider:

```php
use App\Configurables\UseUtcTimezone;
use Foxws\Essentials\Essentials;

Essentials::extend(UseUtcTimezone::class);

// A class-string is resolved through the container; an instance works too.
Essentials::extend(new UseUtcTimezone);
```
