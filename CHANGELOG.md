# Changelog

All notable changes to this project will be documented in this file.

## v2.0.0 - 2026-02-22

### Breaking Changes

- **Configuration migrated to database**: Replaced `config/umami.php` with `spatie/laravel-settings`. Settings are now stored in the database instead of `.env` file.
- **New dependency**: `spatie/laravel-settings ^3.3` is now required.

### Migration Guide

1. Remove any published `config/umami.php` from your application
2. Remove `UMAMI_*` environment variables from `.env` (no longer used)
3. Ensure `spatie/laravel-settings` is configured (the `settings` table must exist)
4. Run `php artisan migrate` to create the Umami settings in the database
5. Set your settings via code:

```php
use JeffersonGoncalves\Umami\Settings\UmamiSettings;

$settings = app(UmamiSettings::class);
$settings->website_id = 'your-website-id';
$settings->host_analytics = 'https://your-umami-instance.com';
$settings->save();
```

### What's Changed

- Removed `config/umami.php` and all `env()` reads
- Added `UmamiSettings` class extending `Spatie\LaravelSettings\Settings`
- Added settings migration with default values
- Updated `UmamiServiceProvider` to register settings class and migration paths
- Updated Blade view to resolve settings from the container
- Updated README with new installation and usage instructions

### Available Settings

| Property | Type | Default | Description |
|----------|------|---------|-------------|
| `website_id` | `?string` | `null` | Your Umami website ID |
| `host_analytics` | `string` | `https://cloud.umami.is` | URL of your Umami instance |
| `host_url` | `?string` | `null` | Override data destination URL |
| `auto_track` | `bool` | `true` | Automatically track pageviews and events |
| `domains` | `?string` | `null` | Comma-delimited list of allowed domains |
| `tag` | `?string` | `null` | Tag to group events in the dashboard |
| `exclude_search` | `bool` | `false` | Exclude search parameters from URL |
| `exclude_hash` | `bool` | `false` | Exclude hash value from URL |

**Full Changelog**: https://github.com/jeffersongoncalves/laravel-umami/compare/v1.1.0...v2.0.0

## v1.1.0 - 2025-03-07

**Full Changelog**: https://github.com/jeffersongoncalves/laravel-umami/compare/v1.0.1...v1.1.0

## v1.0.1 - 2025-03-04

**Full Changelog**: https://github.com/jeffersongoncalves/laravel-umami/compare/v1.0.0...v1.0.1

## v1.0.0 - 2025-03-04

**Full Changelog**: https://github.com/jeffersongoncalves/laravel-umami/commits/v1.0.0
