<?php

declare(strict_types=1);

namespace Foxws\Essentials\Console\Commands;

use Foxws\Essentials\Support\DddSubstitutions;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class DddMakeCommand extends GeneratorCommand
{
    /**
     * The command signature.
     */
    protected $signature = 'ddd:make
        {name : The name of the class}
        {--type= : The type of class to generate, e.g. model, action}
        {--domain= : The domain the class belongs to; guessed from the name if omitted}
        {--layer=Domain : The layer to generate into}
        {--force : Create the class even if it already exists}';

    /**
     * The command description.
     */
    protected $description = 'Create a new DDD class';

    /**
     * Execute the console command.
     */
    public function handle(): int|bool|null
    {
        $type = $this->option('type');

        if (! is_string($type) || $type === '') {
            $this->components->error('The --type option is required, e.g. --type=action.');

            return self::FAILURE;
        }

        if (! array_key_exists($type, DddSubstitutions::get())) {
            $this->components->error(sprintf(
                'Unknown type "%s". Available types: %s.',
                $type,
                implode(', ', array_keys(DddSubstitutions::get())),
            ));

            return self::FAILURE;
        }

        if (! file_exists($this->resolveStubPath("/stubs/{$type}.ddd.stub"))) {
            $this->components->error("No stub found for type \"{$type}\". Expected stubs/{$type}.ddd.stub, or publish your own to base_path('stubs/{$type}.ddd.stub').");

            return self::FAILURE;
        }

        if (config("essentials.layers.{$this->layer()}") === null) {
            $this->components->error("The \"{$this->layer()}\" layer is not configured or has been disabled in essentials.layers.");

            return self::FAILURE;
        }

        $this->type = Str::studly($type);

        return parent::handle();
    }

    /**
     * Get the configured layer for this generator.
     */
    protected function layer(): string
    {
        $layer = $this->option('layer');

        return is_string($layer) ? $layer : 'Domain';
    }

    /**
     * Get the domain the class belongs to, guessing it from the name if not given.
     */
    protected function domain(): string
    {
        if (is_string($domain = $this->option('domain')) && $domain !== '') {
            return $domain;
        }

        preg_match_all('/[A-Z][a-z0-9]*/', Str::studly($this->getNameInput()), $words);

        return $words[0] === [] ? $this->getNameInput() : (string) end($words[0]);
    }

    /**
     * Get the root namespace for the class.
     */
    protected function rootNamespace(): string
    {
        return rtrim((string) config("essentials.layers.{$this->layer()}.namespace"), '\\').'\\';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        $namespace = rtrim($rootNamespace, '\\').'\\'.Str::studly($this->domain());

        $type = $this->option('type');
        $substitution = DddSubstitutions::get()[is_string($type) ? $type : ''] ?? '';

        return $substitution !== '' ? $namespace.'\\'.$substitution : $namespace;
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     */
    protected function getPath($name): string
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        $layerPath = rtrim((string) config("essentials.layers.{$this->layer()}.path"), '/');

        return base_path($layerPath.'/'.str_replace('\\', '/', $name).'.php');
    }

    /**
     * Get the stub file for the generator.
     */
    protected function getStub(): string
    {
        $type = $this->option('type');
        $type = is_string($type) ? $type : '';

        return $this->resolveStubPath("/stubs/{$type}.ddd.stub");
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
     * Build the class with the given name.
     *
     * @param  string  $name
     */
    protected function buildClass($name): string
    {
        return str_replace(
            ['{{ factoryImport }}', '{{factoryImport}}', '{{ factory }}', '{{factory}}'],
            '',
            parent::buildClass($name),
        );
    }
}
