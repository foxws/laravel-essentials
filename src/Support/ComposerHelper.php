<?php

declare(strict_types=1);

namespace Foxws\Essentials\Support;

use Illuminate\Support\Facades\Config;

class ComposerHelper
{
    /**
     * The PSR-4 namespace to relative path map derived from the package configuration.
     *
     * @return array<string, string>
     */
    public static function namespaces(): array
    {
        $namespaces = [
            Path::toNamespace(Config::string('essentials.domain_namespace', 'Domain')) => Path::toRelative(Config::string('essentials.domain_path', base_path('src/Domain'))),
            Path::toNamespace(Config::string('essentials.application_namespace', 'App/Modules')) => Path::toRelative(Config::string('essentials.application_path', base_path('src/App/Modules'))),
        ];

        foreach (Config::array('essentials.layers', []) as $layer => $path) {
            $namespaces[Path::toNamespace($layer)] = Path::toRelative($path);
        }

        $namespaces['Database\\Factories\\'] = 'database/factories/';
        $namespaces['Database\\Seeders\\'] = 'database/seeders/';

        return $namespaces;
    }

    /**
     * Merge the given namespaces into the composer.json autoload.psr-4 map.
     *
     * @param  array<string, mixed>  $composer
     * @param  array<string, string>  $namespaces
     * @return array{0: array<string, mixed>, 1: bool, 2: array<string, string>}
     */
    public static function mergeNamespaces(array $composer, array $namespaces, bool $force = false): array
    {
        $changed = false;
        $conflicts = [];

        foreach ($namespaces as $namespace => $path) {
            $current = $composer['autoload']['psr-4'][$namespace] ?? null;

            if ($current === $path) {
                continue;
            }

            if ($current !== null && ! $force) {
                $conflicts[$namespace] = $current;

                continue;
            }

            $composer['autoload']['psr-4'][$namespace] = $path;
            $changed = true;
        }

        return [$composer, $changed, $conflicts];
    }

    /**
     * Merge the given file into the composer.json autoload.files list.
     *
     * @param  array<string, mixed>  $composer
     * @return array{0: array<string, mixed>, 1: bool}
     */
    public static function mergeAutoloadFile(array $composer, string $file): array
    {
        if (in_array($file, $composer['autoload']['files'] ?? [], true)) {
            return [$composer, false];
        }

        $composer['autoload']['files'][] = $file;

        return [$composer, true];
    }
}
