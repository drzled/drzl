<?php

use Illuminate\Support\Facades\Storage;
use Symfony\Component\Yaml\Yaml;

it('creates the manifest file with default values', function () {
     $manifest = $this->app->make('manifest');
     
     $this->artisan('init');
     
     expect(Storage::exists($manifest->filename))->toBeTrue();
     expect(Storage::get($manifest->filename))->toBe(Yaml::dump($manifest->default()));
});

it('ensures the user is prompted to update the file', function () {
     $this->artisan('init')
          ->expectsOutputToContain('Update the manifest file with your deployment configuration.')
          ->assertSuccessful();
});