<?php

declare(strict_types=1);

namespace Drzl\Commands\Concerns;

trait LockableServer
{
    protected function acquireLock(\Closure $callback): void
    {
        $this->call('lock:acquire', [
            'reason' => 'Automatic deploy lock.',
        ]);

        $callback();

        $this->call('lock:release');
    }
}