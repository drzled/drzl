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
        $this->ensureManifestDoesntExist();

        return match($this->manifest->created()) {
            true => $this->reportSuccess(),
            false => $this->reportFailure(),
        };
    }

    protected function ensureManifestDoesntExist()
    {
        if ($this->manifest->exists()) {
            $this->error('Error: The manifest already exists.');
            $this->line('Please delete the file if you want to generate it again.');
            $this->line('File location: ' . $this->manifest->path());
            
            exit(self::INVALID);
        }
    }

    protected function reportFailure(): int
    {
        $this->error('Error: Unable to generate manifest file.');
        $this->line('Please check the file permissions and try again.');
        $this->line('File location: ' . $this->manifest->path());
        
        return self::FAILURE;
    }

    protected function reportSuccess(): int
    {
        $this->info('Manifest file generated successfully.');
        $this->line('Please update the manifest file with your deployment configuration.');
        $this->line('File location: ' . $this->manifest->path());
        
        return self::SUCCESS;
    }
}