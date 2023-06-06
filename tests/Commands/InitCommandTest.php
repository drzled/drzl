<?php

use Illuminate\Support\Facades\Storage;
use Symfony\Component\Yaml\Yaml;

it('creates the manifest file', function () {
     $manifest = $this->app->make('manifest');
     
     $this->artisan('init');
     
     expect(Storage::exists($manifest->filename))->toBeTrue();
     expect(Storage::get($manifest->filename))->toBe(Yaml::dump($manifest->default()));
});