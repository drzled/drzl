<?php

declare(strict_types=1);

namespace Drzl\Processes;

use Illuminate\Console\OutputStyle;

interface ProcessInterface
{
    public function withOutput(OutputStyle $output): static;
}