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

        try {
            $callback();
        } catch (\Throwable $exception) {
            $this->error($exception->getMessage());
        }

        $this->call('lock:release');
    }
}