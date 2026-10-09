<?php

use Illuminate\Support\Facades\Vite;
use JeffersonGoncalves\Umami\Settings\UmamiSettings;

it('stamps the CSP nonce on every script tag', function () {
    Vite::useCspNonce('test-nonce');
    $settings = app(UmamiSettings::class);
    $settings->website_id = 'test-website-id';
    $settings->save();
    $html = (string) $this->blade('@include("umami::script")');

    preg_match_all('/<script\b[^>]*>/', $html, $tags);

    expect($tags[0])->not->toBeEmpty()->each->toContain('nonce="test-nonce"');
});

it('renders no nonce attribute when the app uses none', function () {
    $settings = app(UmamiSettings::class);
    $settings->website_id = 'test-website-id';
    $settings->save();
    $html = (string) $this->blade('@include("umami::script")');

    expect($html)->toContain('<script')->not->toContain('nonce=');
});
