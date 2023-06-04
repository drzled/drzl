<?php

declare(strict_types=1);

namespace Drzl\Commands;

use Drzl\Manifest;
use Illuminate\Console\Command;

final class InitCommand extends Command
{
    protected $signature = 'init';

    protected $description = 'Initializes the manifiest file with default values';

    public function __construct(protected Manifest $manifest)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $manifestWasCreated = $this->manifest->update(Manifest::default());

        if (! $manifestWasCreated) {
            $this->error('Error: Unable to generate manifest file.');
            $this->line('Please check the file permissions and try again.');
            $this->line('File location: ' . $this->manifest->path());    
            return self::FAILURE;
        }
        
        $this->info('Manifest file generated successfully.');
        $this->line('Please update the manifest file with your deployment configuration.');
        $this->line('File location: ' . $this->manifest->path());
        
        return self::SUCCESS;
    }
}