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
| `Csp\Presets\BasicPreset` | A strict policy: same-origin sources plus the subdomains of `app.url`, nonce-based scripts with `strict-dynamic`, no framing and no plugins |
| `Csp\Presets\IconifyPreset` | Allows `connect-src api.iconify.design`, for `@iconify/vue` and Nuxt UI |
| `Csp\Nonce\ViteNonceGenerator` | Uses `Vite::useCspNonce()`, so the header and the tags Vite renders share one nonce |

```php
// config/csp.php
'presets' => [
    Foxws\Essentials\Csp\Presets\BasicPreset::class,
    Spatie\Csp\Presets\BunnyFonts::class,
],

'nonce_generator' => Foxws\Essentials\Csp\Nonce\ViteNonceGenerator::class,
```

## Middleware

Use `Csp\Middleware\AddCspHeaders` instead of Spatie's middleware. It skips the routes named in `essentials.csp.except` (`boost.*`, `horizon.*` and `telescope.*` by default), whose dashboards ship their own inline scripts:

```php
// bootstrap/app.php
->withMiddleware(function (Middleware $middleware): void {
    $middleware->web(append: [
        Foxws\Essentials\Csp\Middleware\AddCspHeaders::class,
    ]);
})
```

To keep the CSP on Horizon or Telescope instead, remove them from `except` and give the dashboard the nonce: add `Csp\Middleware\AddHorizonCspNonce` to `horizon.middleware`, or `Csp\Middleware\AddTelescopeCspNonce` to `telescope.middleware`.
