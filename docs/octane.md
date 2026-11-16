---
section: Usage
order: 4
---

# Octane and Caddy

When the app runs on [Octane](https://laravel.com/docs/octane) with FrankenPHP, its embedded Caddy server can also reverse proxy the services next to it, such as S3 storage, Reverb or the Vite dev server. Your own reverse proxy then needs a single wildcard entry pointing at the app, instead of an entry and a host port per service.

`Foxws\Essentials\Octane\CaddySites` renders the Caddyfile site blocks for that. Pass them to FrankenPHP as `CADDY_EXTRA_CONFIG` in `config/octane.php`:

```php
use Foxws\Essentials\Octane\CaddySites;

'caddy' => [
    'env' => [
        // The port must match the "--port" passed to "octane:frankenphp".
        'CADDY_EXTRA_CONFIG' => CaddySites::render([
            CaddySites::hostFromUrl((string) env('AWS_URL')) => CaddySites::hostPortFromUrl((string) env('AWS_ENDPOINT')),
            (string) env('VITE_HMR_HOST') => CaddySites::hostPort((string) env('VITE_SERVER_HOST'), (string) env('VITE_SERVER_PORT', 5173)),
            (string) env('VITE_REVERB_HOST', env('REVERB_HOST')) => CaddySites::hostPort((string) env('REVERB_HOST'), (string) env('REVERB_PORT', 8080)),
        ], (int) env('OCTANE_PORT', 8000)),
    ],
],
```

Each key is a public hostname, and each value the internal `host:port` to forward it to. Config files can't depend on each other's load order, so read the values with `env()` here rather than `config()`.

| Method | Returns |
| --- | --- |
| `render(array $sites, int $port)` | One `http://host:port { reverse_proxy upstream }` block per site. Sites with an empty hostname or upstream are skipped, so a service you don't use can stay in the map |
| `hostFromUrl(string $url)` | The hostname of a URL, such as `AWS_URL`, or an empty string |
| `hostPortFromUrl(string $url)` | The `host:port` of a URL, such as `AWS_ENDPOINT`. Empty when the URL has no port, such as AWS S3 itself, which isn't proxied through the app |
| `hostPort(?string $host, int\|string\|null $port)` | `host:port`, or an empty string when either half is missing |

Every block is pinned to `http://`. A bare hostname makes Caddy try automatic HTTPS on port 443, which FrankenPHP can't bind when it runs as a non-root user. Terminate HTTPS at your own reverse proxy in front of the app.

The class only builds a string, so it doesn't need `laravel/octane` to be installed.
