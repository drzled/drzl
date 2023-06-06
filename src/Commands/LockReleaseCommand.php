<?php

declare(strict_types=1);

namespace Drzl\Commands;

use Drzl\Manifest;
use Drzl\Processes\ServerLock;
use LaravelZero\Framework\Commands\Command;

class LockReleaseCommand extends Command
{
    protected $signature = 'lock:release';

    protected $description = 'Release an exclusive lock on the remote server';

    public function __construct(public readonly Manifest $manifest)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $this->line('Releasing the servers lock...');

        $processResult = with($this->manifest->primaryServer(), function ($primaryServer) {
            return ServerLock::on($primaryServer)->releaseLock(
                config('drzl.lockfile')
            );
        });
        
        if ($processResult->successful()) {
            $this->info('Server lock has been released');
        }
    }
}
