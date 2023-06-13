<?php

declare(strict_types=1);

namespace Drzl\Commands;

use Drzl\Commands\Concerns\LockableServer;

class SetupCommand extends BaseCommand
{
    use LockableServer;
    
    protected $signature = 'setup';

    protected $description = 'Configuration the app servers';

    public function handle()
    {
        $this->acquireLock(function () {
            $this->call('server:bootstrap');
        });
    }
}
