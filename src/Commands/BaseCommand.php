<?php

namespace Drzl\Commands;

use Drzl\Manifest;
use Drzl\Processes\ProcessInterface;
use LaravelZero\Framework\Commands\Command;

abstract class BaseCommand extends Command
{
    public function __construct(protected readonly Manifest $manifest)
    {
        parent::__construct();
    }

    protected function withOutput(ProcessInterface $process, \Closure $callback) {
        $process->withOutput($this->getOutput());

        $callback($process);
    }
}
