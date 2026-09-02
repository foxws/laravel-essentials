<?php

declare(strict_types=1);

namespace Foxws\Essentials\Console\Commands;

use Closure;
use Foxws\Essentials\Support\DddSubstitutions;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

abstract class DddMakeCommand extends GeneratorCommand
{
    /**
     * The DddSubstitutions key for this generator's type, e.g. "model", "action".
     */
    protected string $substitution;

    /**
     * The essentials.layers key this generator targets, e.g. "Domain", "Modules".
     */
    protected string $layer = 'Domain';

    /**
     * Execute the console command.
     */
    public function handle(): int|bool|null
    {
        if (config("essentials.layers.{$this->layer}") === null) {
            $this->components->error("The \"{$this->layer}\" layer is not configured or has been disabled in essentials.layers.");

            return self::FAILURE;
        }

        return parent::handle();
    }

    /**
     * Get the root namespace for the class.
     */
    protected function rootNamespace(): string
    {
        return rtrim((string) config("essentials.layers.{$this->layer}.namespace"), '\\').'\\';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        $domain = $this->argument('domain');

        $namespace = rtrim($rootNamespace, '\\').'\\'.Str::studly(is_string($domain) ? $domain : '');

        $type = DddSubstitutions::get()[$this->substitution] ?? '';

        return $type !== '' ? $namespace.'\\'.$type : $namespace;
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     */
    protected function getPath($name): string
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        $layerPath = rtrim((string) config("essentials.layers.{$this->layer}.path"), '/');

        return base_path($layerPath.'/'.str_replace('\\', '/', $name).'.php');
    }

    /**
     * Resolve the stub path, preferring one published to the application's stubs directory.
     */
    protected function resolveStubPath(string $stub): string
    {
        $customPath = base_path(trim($stub, '/'));

        return file_exists($customPath) ? $customPath : __DIR__.'/../../../'.ltrim($stub, '/');
    }

    /**
     * Prompt for missing input arguments using the returned questions.
     *
     * @return array<string, string|array{string, string}|Closure(): (array<int, string>|string|int|bool)>
     */
    protected function promptForMissingArgumentsUsing(): array
    {
        return array_merge(parent::promptForMissingArgumentsUsing(), [
            'domain' => ['Which domain does this belong to?', 'E.g. Posts'],
        ]);
    }
}
