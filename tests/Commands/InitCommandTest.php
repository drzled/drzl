<?php

it('creates the manifest file', function () {
     $this->artisan('init')->assertSuccessful();
});