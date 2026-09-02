<div align="center">
    <h1>Laravel Essentials</h1>
</div>

<p align="center">
    <a href="https://packagist.org/packages/foxws/laravel-essentials"><img src="https://img.shields.io/packagist/v/foxws/laravel-essentials.svg?style=flat-square" alt="Packagist"></a>
    <a href="https://packagist.org/packages/foxws/laravel-essentials"><img src="https://img.shields.io/packagist/php-v/foxws/laravel-essentials.svg?style=flat-square" alt="PHP from Packagist"></a>
    <a href="https://packagist.org/packages/foxws/laravel-essentials"><img src="https://badge.laravel.cloud/badge/foxws/laravel-essentials?style=flat" alt="Laravel versions"></a>
    <a href="https://github.com/foxws/laravel-essentials/actions"><img alt="GitHub Workflow Status (main)" src="https://img.shields.io/github/actions/workflow/status/foxws/laravel-essentials/tests.yml?branch=main&label=Tests&style=flat-square"></a>
    <a href="https://packagist.org/packages/foxws/laravel-essentials"><img src="https://img.shields.io/packagist/dt/foxws/laravel-essentials.svg?style=flat-square" alt="Total Downloads"></a>
</p>

Essentials for Laravel projects

## Installation

You can install the package via Composer:

```bash
composer require foxws/laravel-essentials
```

You may publish all of the package's resources at once:

```bash
php artisan vendor:publish --tag="laravel-essentials"
```

Or, you may publish each resource individually:

### Publishing the Configuration File

```bash
php artisan vendor:publish --tag="laravel-essentials-config"
```

### Publishing and Running the Migrations

```bash
php artisan vendor:publish --tag="laravel-essentials-migrations"
php artisan migrate
```

### Publishing the Views

```bash
php artisan vendor:publish --tag="laravel-essentials-views"
```

### Publishing the Translations

```bash
php artisan vendor:publish --tag="laravel-essentials-lang"
```

### Publishing the Public Assets

```bash
php artisan vendor:publish --tag="laravel-essentials-assets"
```

## Usage

Once installed, Laravel Essentials applies a set of sensible defaults automatically — no code required:

```php
// Model::shouldBeStrict(), URL::forceHttps(), Date::use(CarbonImmutable::class), and more.
```

It also adds Domain Driven Design scaffolding commands:

```bash
php artisan ddd:install
php artisan ddd:make CreateInvoice --type=action --domain=Billing
```

See the [documentation](docs/README.md) for the full list of defaults, how to enable or disable them, and how the DDD commands work.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Thank you for considering contributing to Laravel Essentials! Please review our [contributing guide](.github/CONTRIBUTING.md) to get started.

## Security Vulnerabilities

Please review [our security policy](.github/SECURITY.md) on how to report security vulnerabilities.

## Credits

- [foxws](https://github.com/foxws)
- [All Contributors](../../contributors)

## License

Laravel Essentials is open-sourced software licensed under the [MIT license](LICENSE.md).
