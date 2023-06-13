<?php

namespace Drzl\Commands;

use Drzl\Manifest;
use LaravelZero\Framework\Commands\Command;

abstract class BaseCommand extends Command
{
    public function __construct(protected readonly Manifest $manifest)
    {
        parent::__construct();
    }
}
