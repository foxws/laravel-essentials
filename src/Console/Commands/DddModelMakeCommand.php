<?php

declare(strict_types=1);

namespace Foxws\Essentials\Console\Commands;

use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'ddd:model')]
class DddModelMakeCommand extends DddMakeCommand
{
    /**
     * The command signature.
     */
    protected $signature = 'ddd:model
        {domain : The domain the class belongs to, e.g. Posts}
        {name : The name of the model}
        {--force : Create the class even if it already exists}';

    /**
     * The command description.
     */
    protected $description = 'Create a new DDD model class';

    /**
     * The type of class being generated.
     */
    protected $type = 'Model';

    /**
     * The DddSubstitutions key for this generator's type.
     */
    protected string $substitution = 'model';

    /**
     * Get the stub file for the generator.
     */
    protected function getStub(): string
    {
        return $this->resolveStubPath('/stubs/model.ddd.stub');
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
