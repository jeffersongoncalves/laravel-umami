---
name: umami-development
description: Development guide for the laravel-umami package -- Umami Analytics integration for Laravel using spatie/laravel-settings.
---

# Umami Development Skill

## When to use this skill

- When developing or modifying the `jeffersongoncalves/laravel-umami` package.
- When adding new settings properties to `UmamiSettings`.
- When modifying the Blade tracking script.
- When writing tests for the package.
- When integrating Umami Analytics into a Laravel application.

## Setup

### Requirements

- PHP 8.2 or 8.3
- Laravel 11, 12, or 13
- `spatie/laravel-settings` ^3.3
- `spatie/laravel-package-tools` ^1.14.0

### Installation

```bash
composer require jeffersongoncalves/laravel-umami
php artisan vendor:publish --tag="umami-settings-migrations"
php artisan migrate
```

### Include the tracking script

```blade
<head>
    @include('umami::script')
</head>
```

## Architecture

```
src/
  UmamiServiceProvider.php        # Package service provider (extends PackageServiceProvider)
  Settings/
    UmamiSettings.php             # Spatie Settings class (group: umami)
database/
  settings/
    2026_01_01_000000_create_umami_settings.php
resources/
  views/
    script.blade.php              # Tracking script Blade view
```

### Service Provider

`UmamiServiceProvider` extends `PackageServiceProvider`:
- Registers package name `laravel-umami` with views via `hasViews()`.
- Auto-registers `UmamiSettings` into `settings.settings` config array.
- Registers settings migration path in `settings.migrations_paths`.
- Publishes migrations under tag `umami-settings-migrations`.

### Settings Class

```php
class UmamiSettings extends Settings
{
    public ?string $website_id;
    public string $host_analytics;
    public ?string $host_url;
    public bool $auto_track;
    public ?string $domains;
    public ?string $tag;
    public bool $exclude_search;
    public bool $exclude_hash;

    public static function group(): string { return 'umami'; }
}
```

| Property | Type | Default | Description |
|----------|------|---------|-------------|
| `website_id` | `?string` | `null` | Unique website ID from Umami dashboard |
| `host_analytics` | `string` | `https://cloud.umami.is` | Umami instance URL |
| `host_url` | `?string` | `null` | Custom host URL for data collection |
| `auto_track` | `bool` | `true` | Automatically track page views |
| `domains` | `?string` | `null` | Comma-separated allowed domains |
| `tag` | `?string` | `null` | Tag for filtering analytics data |
| `exclude_search` | `bool` | `false` | Exclude URL search parameters |
| `exclude_hash` | `bool` | `false` | Exclude URL hash from tracking |

### Blade View

The script only renders when `website_id` is not empty. Uses `async defer` for non-blocking loading. Optional attributes (`host_url`, `domains`, `tag`) only render when set. Boolean attributes always render as `"true"` or `"false"`.

```blade
@php($settings = app(\JeffersonGoncalves\Umami\Settings\UmamiSettings::class))

@if(!empty($settings->website_id))
    <script async defer data-website-id="{{ $settings->website_id }}"
            src="{{ $settings->host_analytics }}/script.js"
            @if($settings->host_url) data-host-url="{{ $settings->host_url }}" @endif
            @if($settings->domains) data-domains="{{ $settings->domains }}" @endif
            @if($settings->tag) data-tag="{{ $settings->tag }}" @endif
            data-auto-track="{{ $settings->auto_track ? 'true' : 'false' }}"
            data-exclude-search="{{ $settings->exclude_search ? 'true' : 'false' }}"
            data-exclude-hash="{{ $settings->exclude_hash ? 'true' : 'false' }}">
    </script>
@endif
```

## Features

### Reading and Updating Settings

```php
use JeffersonGoncalves\Umami\Settings\UmamiSettings;

$settings = app(UmamiSettings::class);
$settings->website_id = 'your-website-id';
$settings->host_analytics = 'https://umami.yourdomain.com';
$settings->host_url = 'https://collect.yourdomain.com';
$settings->auto_track = true;
$settings->domains = 'example.com,blog.example.com';
$settings->tag = 'production';
$settings->exclude_search = true;
$settings->exclude_hash = false;
$settings->save();
```

### Disabling Auto-Track

For manual tracking via the Umami JavaScript API:

```php
$settings = app(UmamiSettings::class);
$settings->auto_track = false;
$settings->save();
```

Then use JavaScript: `umami.track('button-click', { label: 'signup' });`

## Configuration

No config file -- all settings stored in the database via `spatie/laravel-settings`.

### Adding New Settings

1. Add the property to `UmamiSettings`.
2. Create a new settings migration with `$this->migrator->add('umami.property_name', default)`.
3. Update `script.blade.php` if the setting maps to a `data-*` attribute.

## Testing Patterns

```bash
composer test           # Run Pest tests
composer test-coverage  # Run with coverage
composer analyse        # PHPStan static analysis
composer format         # Laravel Pint formatting
```

### Example Tests

```php
use JeffersonGoncalves\Umami\Settings\UmamiSettings;

it('renders the tracking script when website_id is set', function () {
    $settings = app(UmamiSettings::class);
    $settings->website_id = 'test-website-id';
    $settings->save();

    $view = $this->blade('@include("umami::script")');
    $view->assertSee('data-website-id="test-website-id"');
    $view->assertSee('src="https://cloud.umami.is/script.js"');
});

it('does not render the script when website_id is null', function () {
    $settings = app(UmamiSettings::class);
    $settings->website_id = null;
    $settings->save();

    $view = $this->blade('@include("umami::script")');
    $view->assertDontSee('<script');
});

it('renders optional data attributes only when set', function () {
    $settings = app(UmamiSettings::class);
    $settings->website_id = 'test-id';
    $settings->host_url = 'https://collect.example.com';
    $settings->domains = 'example.com';
    $settings->tag = 'test-tag';
    $settings->save();

    $view = $this->blade('@include("umami::script")');
    $view->assertSee('data-host-url="https://collect.example.com"');
    $view->assertSee('data-domains="example.com"');
    $view->assertSee('data-tag="test-tag"');
});

it('renders boolean attributes correctly', function () {
    $settings = app(UmamiSettings::class);
    $settings->website_id = 'test-id';
    $settings->auto_track = false;
    $settings->exclude_search = true;
    $settings->exclude_hash = true;
    $settings->save();

    $view = $this->blade('@include("umami::script")');
    $view->assertSee('data-auto-track="false"');
    $view->assertSee('data-exclude-search="true"');
    $view->assertSee('data-exclude-hash="true"');
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
```
