<?php

use JeffersonGoncalves\Umami\Settings\UmamiSettings;

it('renders the tracking script when website_id is set', function () {
    $settings = app(UmamiSettings::class);
    $settings->website_id = 'test-website-id';
    $settings->save();

    $view = $this->blade('@include("umami::script")');

    $view->assertSee('data-website-id="test-website-id"', false)
        ->assertSee('src="https://cloud.umami.is/script.js"', false);
});

it('does not render the script when website_id is null', function () {
    $settings = app(UmamiSettings::class);
    $settings->website_id = null;
    $settings->save();

    $view = $this->blade('@include("umami::script")');

    $view->assertDontSee('<script', false);
});

it('renders optional data attributes only when set', function () {
    $settings = app(UmamiSettings::class);
    $settings->website_id = 'test-id';
    $settings->host_url = 'https://collect.example.com';
    $settings->domains = 'example.com';
    $settings->tag = 'test-tag';
    $settings->save();

    $view = $this->blade('@include("umami::script")');

    $view->assertSee('data-host-url="https://collect.example.com"', false)
        ->assertSee('data-domains="example.com"', false)
        ->assertSee('data-tag="test-tag"', false);
});

it('renders boolean attributes correctly', function () {
    $settings = app(UmamiSettings::class);
    $settings->website_id = 'test-id';
    $settings->auto_track = false;
    $settings->exclude_search = true;
    $settings->exclude_hash = true;
    $settings->save();

    $view = $this->blade('@include("umami::script")');

    $view->assertSee('data-auto-track="false"', false)
        ->assertSee('data-exclude-search="true"', false)
        ->assertSee('data-exclude-hash="true"', false);
});

it('has the correct default values', function () {
    $settings = app(UmamiSettings::class);

    expect($settings->website_id)->toBeNull();
    expect($settings->host_analytics)->toBe('https://cloud.umami.is');
    expect($settings->auto_track)->toBeTrue();
    expect($settings->exclude_search)->toBeFalse();
    expect($settings->exclude_hash)->toBeFalse();
});

it('belongs to the umami group', function () {
    expect(UmamiSettings::group())->toBe('umami');
});
