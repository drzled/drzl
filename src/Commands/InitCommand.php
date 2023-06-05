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
        return match (true) {
            $this->manifest->exists() => $this->reportError('Delete the manifest to generate it again.', self::INVALID),
            $this->manifest->created() => $this->reportSuccess('Manifest file generated successfully.'),
            default => $this->reportError('Unable to generate manifest file. Check the folder permissions.', self::FAILURE),
        };
    }

    protected function reportError(string $message, int $statusCode): int
    {
        $this->error('Error: ' . $message);
        $this->line('File location: ' . $this->manifest->path());
        
        return $statusCode;
    }

    protected function reportSuccess(string $message): int
    {
        $this->info($message);
        $this->line('Update the manifest file with your deployment configuration.');
        $this->line('File location: ' . $this->manifest->path());
        
        return self::SUCCESS;
    }
}
