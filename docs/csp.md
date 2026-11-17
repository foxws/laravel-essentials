---
section: Usage
order: 2
---

# Content Security Policy

Laravel Essentials ships presets, a nonce generator and middleware for [spatie/laravel-csp](https://github.com/spatie/laravel-csp). The package is optional, so install it first:

```bash
composer require spatie/laravel-csp
php artisan vendor:publish --tag="csp-config"
```

## Presets and nonce

| Class | What it does |
| --- | --- |
| `Csp\Presets\BasicPreset` | A strict policy: same-origin sources plus the subdomains of `app.url`, nonce-based scripts with `strict-dynamic`, no framing and no plugins. It adds `upgrade-insecure-requests` only when `app.url` is `https`, because on plain HTTP it breaks same-origin redirects |
| `Csp\Presets\IconifyPreset` | Allows `connect-src api.iconify.design`, for `@iconify/vue` and Nuxt UI |
| `Csp\Presets\ReverbPreset` | Allows Echo to connect to Reverb: `connect-src wss://{host}`, or `ws://` for `http`, with the port when it isn't the scheme's default. It reads the first Reverb app's `wsHost`, `wsPort` and `wsScheme` options (where browsers reach Reverb), falling back to `host`, `port` and `scheme`, and adds nothing without a host |
| `Csp\Nonce\ViteNonceGenerator` | Uses `Vite::useCspNonce()`, so the header and the tags Vite renders share one nonce |

```php
// config/csp.php
'presets' => [
    Foxws\Essentials\Csp\Presets\BasicPreset::class,
    Spatie\Csp\Presets\BunnyFonts::class,
],

'nonce_generator' => Foxws\Essentials\Csp\Nonce\ViteNonceGenerator::class,
```

Then add Spatie's middleware to the web group:

```php
// bootstrap/app.php
->withMiddleware(function (Middleware $middleware): void {
    $middleware->web(append: [
        Spatie\Csp\AddCspHeaders::class,
    ]);
})
```

## Horizon and Telescope

Horizon and Telescope run inside your app, so they get the same policy as every other page. Their dashboards render an inline `<style>` and `<script type="module">`, which only pass the policy with the request's nonce. Add the matching middleware to the dashboard's middleware:

```php
// config/horizon.php
'middleware' => ['web', Foxws\Essentials\Csp\Middleware\AddHorizonCspNonce::class],

// config/telescope.php
'middleware' => [
    'web',
    Foxws\Essentials\Csp\Middleware\AddTelescopeCspNonce::class,
    Laravel\Telescope\Http\Middleware\Authorize::class,
],
```

Both dashboards load their font from fonts.bunny.net, so keep `Spatie\Csp\Presets\BunnyFonts` in `csp.presets`. Boost's browser logger already reads the nonce from Vite, so it needs nothing extra.
