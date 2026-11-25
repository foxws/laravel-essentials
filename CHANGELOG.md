# Release Notes

## [Unreleased](https://github.com/foxws/laravel-essentials/compare/3.2.1...HEAD)

## [3.2.1](https://github.com/foxws/laravel-essentials/compare/3.2.0...3.2.1) - 2026-11-25

3.2.1 lets `IconifyPreset` also allow `api2.iconify.design`, the host `@iconify/vue` falls back to when `api.iconify.design` fails.

<!-- Release notes generated using configuration in .github/release.yml at main -->
### What's Changed

#### Other Changes

* Allow the Iconify fallback host in IconifyPreset by @francoism90 in https://github.com/foxws/laravel-essentials/pull/24

**Full Changelog**: https://github.com/foxws/laravel-essentials/compare/3.2.0...3.2.1

## [3.2.0](https://github.com/foxws/laravel-essentials/compare/3.1.0...3.2.0) - 2026-11-24

<!-- Release notes generated using configuration in .github/release.yml at main -->
### What's Changed

#### Other Changes

* Make ForceRootUrl and SetTrustedProxies opt-in by @francoism90 in https://github.com/foxws/laravel-essentials/pull/23

**Full Changelog**: https://github.com/foxws/laravel-essentials/compare/3.1.0...3.2.0

### Breaking

- `ForceRootUrl` and `SetTrustedProxies` are opt-in: the default config has them commented out, like `ModelUnguard`. They change where links and redirects go, and which proxies are trusted, which is hard to trace in an app that doesn't expect it. Apps without a published config that rely on them publish the config and add them to the `configurables`: `ForceRootUrl::class`, for example to keep a response cache from storing links on a request's host, and `SetTrustedProxies::class`, or `TRUSTED_PROXIES` does nothing. A published config is unchanged.

## [3.1.0](https://github.com/foxws/laravel-essentials/compare/3.0.0...3.1.0) - 2026-11-22

3.1.0 adds `auto` for trusted proxies. It's `*` on Laravel Cloud, whose load balancers have no fixed address, and `private_ranges` elsewhere:

```php
// config/essentials.php
'trusted_proxies' => env('TRUSTED_PROXIES', 'auto'),



```
`SetTrustedProxies` resolves it on boot, so it's also right when the config was cached during a build.

### Upgrading from 3.0

Run `composer update foxws/laravel-essentials`. Nothing changes unless you use `auto`. To use it, require `^3.1`, as 3.0 doesn't know the value, and keep `SetTrustedProxies::class` in your `configurables`.

See [Trusting proxies from the environment](https://github.com/foxws/laravel-essentials/blob/3.1.0/docs/configurables.md#trusting-proxies-from-the-environment).

<!-- Release notes generated using configuration in .github/release.yml at d68e59e3511fe0b56295a4ff9618bf92b1f68d89 -->
### What's Changed

#### Other Changes

* Fix the changelog workflow, and add 2.1.0 and 3.0.0 by @francoism90 in https://github.com/foxws/laravel-essentials/pull/21
* Add auto, for trusted proxies on Laravel Cloud or elsewhere by @francoism90 in https://github.com/foxws/laravel-essentials/pull/22

**Full Changelog**: https://github.com/foxws/laravel-essentials/compare/3.0.0...3.1.0

## [3.0.0](https://github.com/foxws/laravel-essentials/compare/2.1.0...3.0.0) - 2026-11-22

3.0.0 turns on `ForceRootUrl`, which is a breaking change, and adds `SetTrustedProxies`.

### Upgrading from 2.x

Require `^3.0`, then follow the part that applies to your app.

**Without a published `config/essentials.php`:**

- Links and redirects now use `APP_URL` outside `local`, instead of the request's host and port. Set it in every environment, tests and previews included: Laravel's fallback is `http://localhost`.
- If your app serves several hosts, or is reached at other addresses than `APP_URL`, publish the config and remove `ForceRootUrl`. Absolute signed URLs only validate on `APP_URL`'s host.
- Tests that change `app.url` after boot, or expect links on the request's host, will fail.
- If `TRUSTED_PROXIES` is already set in your environment, it now replaces `trustProxies(at: ...)`.

**With a published config:** nothing changes, as your `configurables` replace the default list. Add the ones you want:

```php
'configurables' => [
    // ...
    ForceRootUrl::class,
    SetTrustedProxies::class,
],

'trusted_proxies' => env('TRUSTED_PROXIES'),



```
### New

- `ForceRootUrl` builds the root of generated links from `app.url`. With a response cache, this keeps a request from choosing the host or port of everyone's links. See [Forcing the root URL](https://github.com/foxws/laravel-essentials/blob/3.0.0/docs/configurables.md#forcing-the-root-url) for what it doesn't cover.
- `SetTrustedProxies` sets the trusted proxies from `TRUSTED_PROXIES`, which `bootstrap/app.php` can't read from `.env`. See [Trusting proxies from the environment](https://github.com/foxws/laravel-essentials/blob/3.0.0/docs/configurables.md#trusting-proxies-from-the-environment).

<!-- Release notes generated using configuration in .github/release.yml at 66e486368b9c3e24ae8e4f8a93d88d6a72c8ecc5 -->
### What's Changed

#### Other Changes

* Add ForceRootUrl, enabled by default by @francoism90 in https://github.com/foxws/laravel-essentials/pull/19
* Add SetTrustedProxies, for trusted proxies from the environment by @francoism90 in https://github.com/foxws/laravel-essentials/pull/20

**Full Changelog**: https://github.com/foxws/laravel-essentials/compare/2.1.0...3.0.0

## [2.1.0](https://github.com/foxws/laravel-essentials/compare/2.0.0...2.1.0) - 2026-11-21

<!-- Release notes generated using configuration in .github/release.yml at main -->
### What's Changed

#### Other Changes

* Add a GitHubImagesPreset that allows images from raw.githubusercontent.com by @francoism90 in https://github.com/foxws/laravel-essentials/pull/18

**Full Changelog**: https://github.com/foxws/laravel-essentials/compare/2.0.0...2.1.0

## [2.0.0](https://github.com/foxws/laravel-essentials/compare/1.2.0...2.0.0) - 2026-11-19

This release requires PHP 8.5 or newer. PHP 8.4 is no longer supported, and PHP 8.6 is now tested in CI. Stay on the previous version if you still run PHP 8.4.

<!-- Release notes generated using configuration in .github/release.yml at fdc25f688254fd3230c6a575602ffe3328bfb90f -->
### What's Changed

#### Other Changes

* Add a missing comma to the CSP presets in the Boost skill by @francoism90 in https://github.com/foxws/laravel-essentials/pull/16
* Drop PHP 8.4 and add PHP 8.6 by @francoism90 in https://github.com/foxws/laravel-essentials/pull/17

**Full Changelog**: https://github.com/foxws/laravel-essentials/compare/1.2.0...2.0.0

## [1.2.0](https://github.com/foxws/laravel-essentials/compare/1.1.1...1.2.0) - 2026-11-17

<!-- Release notes generated using configuration in .github/release.yml at 25a6c6ba79bd21079ea035ccd781b52431b5eaf0 -->
### What's Changed

#### Other Changes

* Add a ReverbPreset that lets Echo connect to Reverb by @francoism90 in https://github.com/foxws/laravel-essentials/pull/15

**Full Changelog**: https://github.com/foxws/laravel-essentials/compare/1.1.1...1.2.0

## [1.1.1](https://github.com/foxws/laravel-essentials/compare/1.1.0...1.1.1) - 2026-11-14

<!-- Release notes generated using configuration in .github/release.yml at 0cc9ba2580363826f0938349c854a73cf7bdc390 -->
### What's Changed

#### Other Changes

* Only upgrade insecure requests when the app runs on HTTPS by @francoism90 in https://github.com/foxws/laravel-essentials/pull/13

**Full Changelog**: https://github.com/foxws/laravel-essentials/compare/1.1.0...1.1.1

## [1.1.0](https://github.com/foxws/laravel-essentials/compare/1.0.0...1.1.0) - 2026-11-14

<!-- Release notes generated using configuration in .github/release.yml at b5da6a116ae685f7fe92738ee0c9c0c884031806 -->
### What's Changed

#### Other Changes

* Bump shivammathur/setup-php from 2.37.2 to 2.40.0 by @dependabot[bot] in https://github.com/foxws/laravel-essentials/pull/9
* Add CSP presets and nonce middleware, AsDateTime, HasUlid, Enumerable and HasLabels by @francoism90 in https://github.com/foxws/laravel-essentials/pull/12

### New Contributors

* @dependabot[bot] made their first contribution in https://github.com/foxws/laravel-essentials/pull/9

**Full Changelog**: https://github.com/foxws/laravel-essentials/compare/1.0.0...1.1.0

## [1.0.0](https://github.com/foxws/laravel-essentials/compare/0.0.5...1.0.0) - 2026-11-12

<!-- Release notes generated using configuration in .github/release.yml at main -->
### What's Changed

#### Other Changes

* Read ESSENTIALS_CONFIGURABLES as a comma-separated list by @francoism90 in https://github.com/foxws/laravel-essentials/pull/11

**Full Changelog**: https://github.com/foxws/laravel-essentials/compare/0.0.5...1.0.0

## [0.0.5](https://github.com/foxws/laravel-essentials/compare/0.0.4...0.0.5) - 2026-10-14

<!-- Release notes generated using configuration in .github/release.yml at main -->
### What's Changed

#### Other Changes

* Add Laravel Boost tip to README and docs by @francoism90 in https://github.com/foxws/laravel-essentials/pull/8

**Full Changelog**: https://github.com/foxws/laravel-essentials/compare/0.0.4...0.0.5

## [0.0.4](https://github.com/foxws/laravel-essentials/compare/0.0.3...0.0.4) - 2026-10-02

<!-- Release notes generated using configuration in .github/release.yml at main -->
### What's Changed

#### Other Changes

* docs: credit nunomaduro/essentials and explain the configuration difference by @francoism90 in https://github.com/foxws/laravel-essentials/pull/5
* docs: add the foxws.nl homepage group and a hero lead by @francoism90 in https://github.com/foxws/laravel-essentials/pull/6
* Raise PHPStan to level 8 by @francoism90 in https://github.com/foxws/laravel-essentials/pull/7

**Full Changelog**: https://github.com/foxws/laravel-essentials/compare/0.0.3...0.0.4

## [0.0.3](https://github.com/foxws/laravel-essentials/compare/0.0.2...0.0.3) - 2026-09-16

<!-- Release notes generated using configuration in .github/release.yml at main -->
### What's Changed

#### Other Changes

* Docs/laravel docs metadata by @francoism90 in https://github.com/foxws/laravel-essentials/pull/4

**Full Changelog**: https://github.com/foxws/laravel-essentials/compare/0.0.2...0.0.3

## [0.0.2](https://github.com/foxws/laravel-essentials/compare/0.0.1...0.0.2) - 2026-09-15

<!-- Release notes generated using configuration in .github/release.yml at main -->
### What's Changed

#### Other Changes

* docs: complete bundled Boost skill for laravel-essentials by @francoism90 in https://github.com/foxws/laravel-essentials/pull/3

**Full Changelog**: https://github.com/foxws/laravel-essentials/compare/0.0.1...0.0.2

## [0.0.1](https://github.com/foxws/laravel-essentials/compare/v0.1.0...0.0.1) - 2026-09-03

<!-- Release notes generated using configuration in .github/release.yml at main -->
### What's Changed

#### Other Changes

* Refactor configuration management and implement Domain Driven Design by @francoism90 in https://github.com/foxws/laravel-essentials/pull/1
* Enhance documentation and add configuration references by @francoism90 in https://github.com/foxws/laravel-essentials/pull/2

### New Contributors

* @francoism90 made their first contribution in https://github.com/foxws/laravel-essentials/pull/1

**Full Changelog**: https://github.com/foxws/laravel-essentials/commits/0.0.1

## [v0.1.0](https://github.com/foxws/laravel-essentials/compare/...v0.1.0) - 202x-xx-xx

Initial pre-release.
