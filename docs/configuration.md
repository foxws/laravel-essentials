# Configuration Reference

Publish the config file to customize any of these options:

```bash
php artisan vendor:publish --tag="laravel-essentials-config"
```

| Key | Env | Default | Description |
| --- | --- | --- | --- |
| `configurables` | `ESSENTIALS_CONFIGURABLES` | see [Configurables](configurables.md#built-in-configurables) | Configurable classes applied on boot. |
| `morph_map` | `ESSENTIALS_MORPH_MAP` | `[]` | `alias => Model::class` pairs enforced via `Relation::enforceMorphMap()`. |
| `ddd_substitutions` | `ESSENTIALS_DDD_SUBSTITUTIONS` | `[]` | Overrides for the `--type` → subfolder mapping used by `ddd:make`. |
| `ddd_stubs` | `ESSENTIALS_DDD_STUBS` | `[]` | `type => stub path` overrides for `ddd:make`. |
| `layers` | — | `Domain`, `Modules`, `Foundation`, `Support` | DDD layers, each with a `namespace` and `path`. |

See [Domain Driven Design](domain-driven-design.md) for how `layers`, `ddd_substitutions`, and `ddd_stubs` are used, and [Configurables](configurables.md) for `configurables`.

## Morph Map Example

```php
// config/essentials.php
'morph_map' => [
    'user' => App\Models\User::class,
    'post' => Domain\Posts\Models\Post::class,
],
```
