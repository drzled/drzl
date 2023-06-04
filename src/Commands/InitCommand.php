<?php

declare(strict_types=1);

namespace Drzl\Commands;

use Illuminate\Console\Command;

final class InitCommand extends Command
{
    protected $signature = 'init';

    protected $description = 'Initializes the manifiest file with default values';

    public function handle(): void
    {
    }
}