# Configuration Reference

Publish the config file to customize any of these options:

```bash
php artisan vendor:publish --tag="essentials-config"
```

| Key | Env | Default | Description |
| --- | --- | --- | --- |
| `configurables` | `ESSENTIALS_CONFIGURABLES` | see [Configurables](configurables.md#built-in-configurables) | Configurable classes applied on boot. |
| `morph_map` | `ESSENTIALS_MORPH_MAP` | `[]` | `alias => Model::class` pairs enforced via `Relation::enforceMorphMap()`. |

See [Configurables](configurables.md) for `configurables`.

## Morph Map Example

```php
// config/essentials.php
'morph_map' => [
    'user' => App\Models\User::class,
    'post' => Domain\Posts\Models\Post::class,
],
```
