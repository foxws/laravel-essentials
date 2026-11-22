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
| `ForceRootUrl`                        | Outside `local`, with an `app.url`  | `URL::useOrigin()` with `app.url`                                                                  |
| `ForceSecurePassword`                 | Running in production               | `Password::defaults()` with a 12–64 char, mixed-case, numbers, symbols, and "uncompromised" policy |
| `ImmutableDates`                      | Always                              | `Date::use(CarbonImmutable::class)`                                                                |
| `ModelShouldBeStrict`                 | Always                              | `Model::shouldBeStrict()`                                                                          |
| `ModelUnguard`                        | Opt-in                              | `Model::unguard()`                                                                                 |
| `PreventStrayRequests`                | Running unit tests                  | `Http::preventStrayRequests()`                                                                     |
| `ProhibitDestructiveCommands`         | Running in production               | `DB::prohibitDestructiveCommands()`                                                                |
| `ResourceWithoutWrapping`             | Always                              | `JsonResource::withoutWrapping()`                                                                  |
| `SetTrustedProxies`                   | `essentials.trusted_proxies` is set | `TrustProxies::at(...)`                                                                            |

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

`ForceRootUrl` takes them from `app.url` instead. It's on by default, so every environment other than `local` needs the right `APP_URL`, previews included.

A published config replaces the default list, so an app that published it before this configurable existed has to add it:

```php
// config/essentials.php
'configurables' => [
    Foxws\Essentials\Configurables\ForceHttpsScheme::class,
    Foxws\Essentials\Configurables\ForceRootUrl::class,
    // ...
],
```

Remove it from that list if the app answers on several hosts, or is reached at other addresses than `app.url`. Otherwise:

- Keep `ForceHttpsScheme` next to it. Without it, the scheme still comes from the request.
- Links and redirects always go to `app.url`, and absolute signed URLs only validate on its host.
- It reads `app.url` once, on boot. Changing that config later, as in a test, doesn't move the links.
- It only changes the URL generator's root. `request()->url()`, `url()->full()` and pagination links still follow the request, and so does the port of a route with its own domain.

## Trusting proxies from the environment

`trustProxies(at: ...)` in `bootstrap/app.php` only suits fixed values: that callback runs before `.env` and the config are loaded, so `env()` doesn't see `.env` there and `config()` fails. `SetTrustedProxies` sets the proxies once your app has booted, so they can come from `.env`, with a cached config too:

```ini
TRUSTED_PROXIES=private_ranges
```

It takes addresses or networks separated by commas, `private_ranges`, `*` for any, or `auto`:

| Where the app runs | `auto` trusts                                         |
| ------------------ | ----------------------------------------------------- |
| Laravel Cloud      | `*`, as its load balancers have no fixed address       |
| Anywhere else      | `private_ranges`                                      |

`auto` is detected on boot, so it's also right when the config was cached during a build. For a default of your own, set it in the published config:

```php
// config/essentials.php
'trusted_proxies' => env('TRUSTED_PROXIES', 'auto'),
```

A value here replaces `trustProxies(at: ...)`. Which headers count stays in `bootstrap/app.php`. Laravel believes `X-Forwarded-Host` by default, which lets a client choose the host unless your proxy overwrites that header, so leave it out if you don't need it:

```php
$middleware->trustProxies(
    headers: Request::HEADER_X_FORWARDED_FOR |
        Request::HEADER_X_FORWARDED_PORT |
        Request::HEADER_X_FORWARDED_PROTO,
);
```

A config published before this configurable existed needs `SetTrustedProxies::class` in its `configurables`. Restart Octane, or cache the config again, after changing the value.

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
