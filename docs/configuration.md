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
| `configurables` | `ESSENTIALS_CONFIGURABLES` | see [Configurables](configurables.md#built-in-configurables) | The list of configurable classes to apply on boot. |
| `morph_map` | `ESSENTIALS_MORPH_MAP` | `[]` | `alias => Model::class` pairs, enforced with `Relation::enforceMorphMap()`. |

See [Configurables](configurables.md) for what each entry in `configurables` does.

## Morph map example

```php
// config/essentials.php
'morph_map' => [
    'user' => App\Models\User::class,
    'post' => Domain\Posts\Models\Post::class,
],
```
