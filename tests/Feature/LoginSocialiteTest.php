<?php

test('it can login facebook', function () {

    $enabled = config('services.facebook.enable');
    if (!$enabled) {
        $this->markTestSkipped('Facebook login is not enabled. Make sure to run artisan config:clear.');
        return;
    }

    $clientId = config('services.facebook.client_id');
    $clientSecret = config('services.facebook.client_secret');
    $this->assertNotEmpty($clientId, 'Facebook login client ID is not set.');
    $this->assertNotEmpty($clientSecret, 'Facebook login client secret is not set.');
});


test('it can login twitter', function () {

    $enabled = config('services.twitter.enable');
    if (!$enabled) {
        $this->markTestSkipped('Twtter login is not enabled. Make sure to run artisan config:clear.');
        return;
    }

    $clientId = config('services.twitter.client_id');
    $clientSecret = config('services.twitter.client_secret');
    $this->assertNotEmpty($clientId, 'Twtter login client ID is not set.');
    $this->assertNotEmpty($clientSecret, 'Twtter login client secret is not set.');
});

test('it can login google', function () {

    $enabled = config('services.google.enable');
    if (!$enabled) {
        $this->markTestSkipped('Google login is not enabled. Make sure to run artisan config:clear.');
        return;
    }

    $clientId = config('services.google.client_id');
    $clientSecret = config('services.google.client_secret');
    $this->assertNotEmpty($clientId, 'Google login client ID is not set.');
    $this->assertNotEmpty($clientSecret, 'Google login client secret is not set.');
});

