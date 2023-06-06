<?php

declare(strict_types=1);

namespace Drzl;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;

class DrzlServiceProvider extends ServiceProvider
{
    public function register(): void
    {
         $this->app->singleton(
            Manifiest::class, 
            fn ($app) => new Manifest($app->make(Filesystem::class))
        );

        $this->app->bind('manifest', Manifest::class);
    }

    public function boot(): void
    {
    }
}