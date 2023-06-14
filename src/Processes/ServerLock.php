<?php

declare(strict_types=1);

namespace Drzl\Processes;

use Illuminate\Contracts\Process\ProcessResult;

final class ServerLock extends ProcessBase
{
    public function getExclusiveLock(string $lockfile, string $reason): ProcessResult
    {
        return $this->command("if [ -e \"{$lockfile}\" ]; then cat {$lockfile} | base64 --decode 1>&2; exit 1; else echo '{$reason}' | base64 > {$lockfile}; fi")
                    ->run();
    }

    public function releaseLock(string $lockfile): ProcessResult
    {
        return $this->command("rm {$lockfile}")
                    ->run();
    }
}