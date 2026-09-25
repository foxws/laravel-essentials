---
title: Introduction
metadata:
  role: Defaults
  eyebrow: "Opinionated Defaults · Boot-time Config"
  desc: "Sensible Laravel defaults, applied automatically on boot."
  requires: "PHP ^8.4"
  laravel: "13.x"
  licence: MIT
---

# Introduction

Laravel Essentials turns on a set of sensible Laravel defaults for you, automatically, as soon as your app boots. There's no code to write — install the package and things like `Model::shouldBeStrict()` and `URL::forceHttps()` are already switched on.

Each default is called a "configurable". It's a small class that checks whether it should run, then applies itself. You can turn any of them on or off, or write your own.

## How this differs from nunomaduro/essentials

This package is inspired by [nunomaduro/essentials](https://github.com/nunomaduro/essentials) and covers similar ground, but configures itself differently:

- **Opt-in, not opt-out.** Upstream ships every default on and lets you turn individual ones off through a `disabled` array. Here you list the configurables you want in an explicit, ordered `configurables` array — see [Configuration Reference](configuration.md).
- **Each configurable decides for itself.** A configurable implements `enabled(): bool` and `configure(): void`, so it can be conditionally active (e.g. only in production, or only once a related config key is set) instead of being a flat always-on/always-off toggle.
- **Extendable at runtime.** Other packages can register their own configurables with `Essentials::extend()` from their own service provider, without the consuming app touching `config/essentials.php` at all — see [Configurables](configurables.md#writing-your-own-configurable).

## Installation

Install the package with Composer:

```bash
composer require foxws/laravel-essentials
```

If you want to change any settings, publish the config file:

```bash
php artisan vendor:publish --tag="essentials-config"
```

## Where to go next

- [Configurables](configurables.md) — the built-in defaults, and how to write your own.
- [Configuration Reference](configuration.md) — every option in `config/essentials.php`.

Looking for Domain Driven Design scaffolding (`ddd:install`, `ddd:make`)? That moved to the separate [foxws/laravel-ddd](https://github.com/foxws/laravel-ddd) package.
