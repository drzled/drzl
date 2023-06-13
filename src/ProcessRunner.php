<?php

declare(strict_types=1);

namespace Drzl;

use Illuminate\Contracts\Process\ProcessResult;
use Illuminate\Support\Facades\Process;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Stopwatch\Stopwatch;

final class ProcessRunner
{
    protected ConsoleOutput $output;

    protected Stopwatch $stopwatch;

    public function __construct()
    {
        $this->output = app('output');

        $this->stopwatch = new Stopwatch();
    }


    public function __invoke($process, bool $stream = false): ProcessResult
    {
        $server = $process->server;

        return Process::run($process->script(), function($type, $message) use ($server, $stream) {
            if ($stream) {
                $this->output->writeln('');
                $this->output->writeln("<comment>INFO [{$server}] {$message}</comment>");
            }
        });        
    }
}