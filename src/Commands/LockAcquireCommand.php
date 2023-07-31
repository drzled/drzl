<?php

declare(strict_types=1);

namespace Drzl\Commands;

use Drzl\Processes\ServerLock;

class LockAcquireCommand extends BaseCommand
{
    protected $signature = 'lock:acquire
                            {reason : Helps identify the purpose of the lock}';

    protected $description = 'Obtain an exclusive lock on the remote server';

    public function handle()
    {
        $this->line('Acquiring the servers lock...');

        $processResult = with($this->manifest->primaryServer(), function ($primaryServer) {
            return ServerLock::on($primaryServer)->getExclusiveLock(
                config('drzl.lockfile'),
                $this->argument('reason')
            );
        });

        if ($processResult->failed()) {
            $this->error('Error: Unable to acquire server lock.');
            return self::FAILURE;
        }

        $this->info('Server lock has been acquired');
    }
}
