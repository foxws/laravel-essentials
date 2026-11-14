---
section: Reference
order: 1
---

# Configuration Reference

Publish the config file to change any of these options:

```bash
php artisan vendor:publish --tag="essentials-config"
```

| Key | Env | Default | Description |
| --- | --- | --- | --- |
| `configurables` | `ESSENTIALS_CONFIGURABLES` | see [Configurables](configurables.md#built-in-configurables) | The list of configurable classes to apply on boot. The env variable takes a comma-separated list of classes. |
| `morph_map` | — | `[]` | `alias => Model::class` pairs, enforced with `Relation::enforceMorphMap()`. |
| `helpers` | `ESSENTIALS_HELPERS` | `true` | Loads the `markdown()` helper. See [Helpers, casts, concerns and contracts](helpers.md). |

See [Configurables](configurables.md) for what each entry in `configurables` does.

## Morph map example

```php
// config/essentials.php
'morph_map' => [
    'user' => App\Models\User::class,
    'post' => Domain\Posts\Models\Post::class,
],
```
