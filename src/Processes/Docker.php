<?php

declare(strict_types=1);

namespace Drzl\Processes;

use Illuminate\Contracts\Process\ProcessResult;

final class Docker extends ProcessBase
{
    public function install(): ProcessResult
    {
        return $this->pipe(['curl -fsSL https://get.docker.com', 'sh'])->run();
    }

    public function isInstalled(): ProcessResult
    {
        return $this->docker(argument: '-v');
    }

    public function hasSuperuserPermissions(): ProcessResult
    {
        return $this->command('[ "${EUID:-$(id -u)}" -eq 0 ]')->run();
    }
}