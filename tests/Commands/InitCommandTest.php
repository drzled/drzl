<?php

use Illuminate\Support\Facades\Storage;

it('creates the manifest file', function () {
     $filename = $this->app->make('manifest')->filename;
     
     $this->artisan('init')
          ->expectsOutputToContain('Manifest file generated successfully.')
          ->assertSuccessful();
     
     expect(Storage::exists($filename))->toBeTrue();
});