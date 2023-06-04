<?php

namespace Tests;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use LaravelZero\Framework\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

     protected function setUp(): void
     {
        parent::setUp();

        $this->app->bind(Filesystem::class, fn() => Storage::fake());
     }
}
