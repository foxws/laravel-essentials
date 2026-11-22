---
section: Usage
order: 1
---

# Configurables

Laravel Essentials turns on a set of opinionated defaults once your app has booted. Each default is a small class called a "configurable".

## How it works

Every configurable implements `Foxws\Essentials\Contracts\Configurable`:

```php
use Foxws\Essentials\Contracts\Configurable;

interface Configurable
{
    public function enabled(): bool;

    public function configure(): void;
}
```

After your app boots, `Foxws\Essentials\Essentials::configure()` looks at every configurable in the list, keeps only the ones whose `enabled()` returns `true`, and calls `configure()` on each of those. This happens automatically — you don't need to call anything yourself.

## Built-in configurables

| Configurable                          | Enabled when                        | What it does                                                                                        |
| -------------------------------------- | ------------------------------------ | ----------------------------------------------------------------------------------------------------- |
| `AggressivePrefetching`               | Always                              | `Vite::useAggressivePrefetching()`                                                                 |
| `AutomaticallyEagerLoadRelationships` | Always                              | `Model::automaticallyEagerLoadRelationships()`                                                     |
| `EnforceMorphMap`                     | `essentials.morph_map` is not empty | `Relation::enforceMorphMap(...)`                                                                   |
| `FakeSleep`                           | Running unit tests                  | `Sleep::fake()`                                                                                    |
| `ForceHttpsScheme`                    | Always                              | `URL::forceHttps()`                                                                                |
| `ForceRootUrl`                        | Opt-in, outside `local`             | `URL::useOrigin()` with `app.url`                                                                  |
| `ForceSecurePassword`                 | Running in production               | `Password::defaults()` with a 12–64 char, mixed-case, numbers, symbols, and "uncompromised" policy |
| `ImmutableDates`                      | Always                              | `Date::use(CarbonImmutable::class)`                                                                |
| `ModelShouldBeStrict`                 | Always                              | `Model::shouldBeStrict()`                                                                          |
| `ModelUnguard`                        | Opt-in                              | `Model::unguard()`                                                                                 |
| `PreventStrayRequests`                | Running unit tests                  | `Http::preventStrayRequests()`                                                                     |
| `ProhibitDestructiveCommands`         | Running in production               | `DB::prohibitDestructiveCommands()`                                                                |
| `ResourceWithoutWrapping`             | Always                              | `JsonResource::withoutWrapping()`                                                                  |

Want to change which ones run, or the order they run in? Publish the config file and edit the `configurables` array:

```bash
php artisan vendor:publish --tag="essentials-config"
```

```php
// config/essentials.php
'configurables' => [
    Foxws\Essentials\Configurables\ForceHttpsScheme::class,
    Foxws\Essentials\Configurables\ImmutableDates::class,
    // ...
],
```

## Forcing the root URL

`ForceHttpsScheme` only sets the scheme: the host and port of a generated link still come from the request. When such a link ends up in a response cache, or in a mail sent during a request, whoever made that request chose where it points.

`ForceRootUrl` takes them from `app.url` instead. It's opt-in, because every environment other than `local` then needs the right `APP_URL`, previews included. Turn it on in the published config:

```php
// config/essentials.php
'configurables' => [
    Foxws\Essentials\Configurables\ForceHttpsScheme::class,
    Foxws\Essentials\Configurables\ForceRootUrl::class,
    // ...
],
```

Before you turn it on:

- Keep `ForceHttpsScheme` next to it. Without it, the scheme still comes from the request.
- An app that answers on several hosts links and redirects to `app.url` on all of them, and absolute signed URLs only validate on that host.
- It only changes the URL generator's root. `request()->url()`, `url()->full()` and pagination links still follow the request, and so does the port of a route with its own domain.

## Writing your own configurable

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

Add it to `config('essentials.configurables')`, or register it while your app is running — for example, from your own package's service provider:

```php
use App\Configurables\UseUtcTimezone;
use Foxws\Essentials\Essentials;

Essentials::extend(UseUtcTimezone::class);

// A class-string is resolved through the container; an instance works too.
Essentials::extend(new UseUtcTimezone);
```
