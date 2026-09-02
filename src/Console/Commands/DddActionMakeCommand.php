<?php

declare(strict_types=1);

namespace Foxws\Essentials\Console\Commands;

use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'ddd:action')]
class DddActionMakeCommand extends DddMakeCommand
{
    /**
     * The command signature.
     */
    protected $signature = 'ddd:action
        {domain : The domain the class belongs to, e.g. Posts}
        {name : The name of the action}
        {--force : Create the class even if it already exists}';

    /**
     * The command description.
     */
    protected $description = 'Create a new DDD action class';

    /**
     * The type of class being generated.
     */
    protected $type = 'Action';

    /**
     * The DddSubstitutions key for this generator's type.
     */
    protected string $substitution = 'action';

    /**
     * Get the stub file for the generator.
     */
    protected function getStub(): string
    {
        return $this->resolveStubPath('/stubs/action.ddd.stub');
    }
}
