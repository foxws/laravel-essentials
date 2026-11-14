---
section: Usage
order: 3
---

# Helpers and casts

## Helpers

With `essentials.helpers` on (the default, or `ESSENTIALS_HELPERS=false` to turn it off), these functions are loaded. A function your app already defines is left alone.

| Function | What it does |
| --- | --- |
| `markdown(?string $value): string` | Renders Markdown with `Str::markdown()`, stripping raw HTML and unsafe links. Blank values give `''`. |
| `toast(string $title, string $description, string $type = 'success'): void` | Flashes `title`, `description` and `type` to the next Inertia response with `Inertia::flash()`. Only defined when `inertiajs/inertia-laravel` is installed. |

```php
toast(__('Settings saved'), __('Your settings have been updated.'));

return back();
```

## AsDateTime

`Foxws\Essentials\Casts\AsDateTime` stores a date as a date-time string in `app.timezone`, whatever timezone it was given in, and reads blank values as `null`. Dates come from the `Date` factory, so they're immutable when `ImmutableDates` runs.

```php
protected function casts(): array
{
    return [
        'published_at' => AsDateTime::class,
    ];
}
```
