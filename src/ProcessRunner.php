<?php

declare(strict_types=1);

namespace Drzl;

use Illuminate\Console\OutputStyle;
use Illuminate\Contracts\Process\ProcessResult;
use Illuminate\Support\Facades\Process;
use Symfony\Component\Stopwatch\Stopwatch;

final class ProcessRunner
{
    protected Stopwatch $stopwatch;

    public function __construct()
    {
        $this->stopwatch = new Stopwatch();
    }


    public function __invoke($process, ?OutputStyle $output = null): ProcessResult
    {
        $server = $process->server;

        return Process::run($process->script(), function($type, $message) use ($server, $output) {
                $output?->writeln('');
                $output?->writeln("<comment>INFO [{$server}] {$message}</comment>");
        });        
    }
}