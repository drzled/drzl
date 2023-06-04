<?php

declare(strict_types=1);

namespace Drzl;

use Illuminate\Support\ServiceProvider;

class DrzlServiceProvider extends ServiceProvider
{
    public function register(): void
    {
         $this->app->singleton(
            Manifiest::class, 
            fn ($app) => $app->make(Manifiest::class)
        );
    }

    public function boot(): void
    {
    }
}