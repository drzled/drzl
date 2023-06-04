<?php

it('creates the manifest file', function () {
     $this->artisan('init')
          ->expectsOutputToContain('Manifest file generated successfully.')
          ->assertSuccessful();
});