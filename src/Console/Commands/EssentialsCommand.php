<?php

declare(strict_types=1);

namespace Essentials\Essentials\Console\Commands;

use Illuminate\Console\Command;

class EssentialsCommand extends Command
{
    /**
     * The command signature.
     */
    protected $signature = 'laravel-essentials:placeholder';

    /**
     * The command description.
     */
    protected $description = 'Placeholder Artisan command shipped by the package laravel-essentials.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->line('Essentials placeholder command executed.');

        return self::SUCCESS;
    }
}
