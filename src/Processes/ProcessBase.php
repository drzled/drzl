<?php

declare(strict_types=1);

namespace Drzl\Processes;

use Drzl\ProcessRunner;
use Drzl\Processes\Concerns\RunnableOverSSH;
use Illuminate\Console\OutputStyle;
use Illuminate\Contracts\Process\ProcessResult;
use Illuminate\Support\Arr;

abstract class ProcessBase implements ProcessInterface
{
    use RunnableOverSSH;

    public readonly string $script;
    
    protected ?OutputStyle $output = null;

    protected ProcessRunner $runner;

    final public function __construct(public readonly string $server)
    {        
        $this->runner = new ProcessRunner();
    }

    public static function on(string $server): static
    {
        return new static($server);
    }

    public function command(string $script): static
    {
        $this->script = $script;

        return $this;
    }

    public function pipe(array $commandsToPipe): static
    {
        return $this->command(Arr::join($commandsToPipe, ' | '));
    }

    public function script(): string
    {
        if (in_array($this->server, ['localhost', '127.0.0.1'])) {
            return $this->script;
        }

        return $this->prepareScriptOverSSH();
    }

    public function run(): ProcessResult
    {
        return $this->runner->__invoke(
            process:$this,
            output: $this->output
        );
    }

    public function withOutput(OutputStyle $output): static
    {
        $this->output = $output;

        return $this;
    }

    public function docker(string $argument): ProcessResult
    {
        $this->script = "docker {$argument}";

        return $this->run();
    }
}