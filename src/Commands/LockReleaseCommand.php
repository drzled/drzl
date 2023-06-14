<?php

declare(strict_types=1);

namespace Drzl\Commands;

use Drzl\Processes\ServerLock;

class LockReleaseCommand extends BaseCommand
{
    protected $signature = 'lock:release';

    protected $description = 'Release an exclusive lock on the remote server';

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
