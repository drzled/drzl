<?php

declare(strict_types=1);

namespace Drzl\Processes\Concerns;

trait RunnableOverSSH
{
    protected function prepareScriptOverSSH(): string
    {
        return sprintf(
            "ssh %s -T -p%s %s@%s '%s'",
            '-o LogLevel=ERROR -o "StrictHostKeyChecking=no" -o "UserKnownHostsFile=/dev/null"',
            config('larsk.ssh_port', '22'),
            config('larsk.ssh_user', 'root'),
            $this->server,
            $this->script
        );
    }
}