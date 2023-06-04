<?php

namespace Tests;

use Drzl\DrzlServiceProvider;
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

     protected function tearDown(): void
    {
        parent::tearDown();
    }

    protected function getPackageProviders($app)
    {
        $serviceProviders = [
            DrzlServiceProvider::class,
        ];

        return $serviceProviders;
    }
}
