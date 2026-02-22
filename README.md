<div class="filament-hidden">

![Laravel Umami](https://raw.githubusercontent.com/jeffersongoncalves/laravel-umami/master/art/jeffersongoncalves-laravel-umami.png)

</div>

# Laravel Umami

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jeffersongoncalves/laravel-umami.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/laravel-umami)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/jeffersongoncalves/laravel-umami/fix-php-code-style-issues.yml?branch=master&label=code%20style&style=flat-square)](https://github.com/jeffersongoncalves/laravel-umami/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/jeffersongoncalves/laravel-umami.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/laravel-umami)

This Laravel package seamlessly integrates Umami analytics into your Blade templates. Easily track website visits and user engagement directly within your Laravel application, providing valuable insights into your website's performance. This package simplifies the integration process, saving you time and effort. With minimal configuration, you can leverage Umami's powerful analytics features to gain a clearer understanding of your audience and website usage.

## Requirements

- PHP 8.2+
- Laravel 11+
- [spatie/laravel-settings](https://github.com/spatie/laravel-settings) configured (the `settings` table must exist)

## Installation

Install the package via composer:

```bash
composer require jeffersongoncalves/laravel-umami
```

If you haven't already, publish the `spatie/laravel-settings` migration to create the `settings` table:

```bash
php artisan vendor:publish --provider="Spatie\LaravelSettings\LaravelSettingsServiceProvider" --tag="migrations"
```

Then publish and run the Umami settings migration:

```bash
php artisan vendor:publish --tag=umami-settings-migrations
php artisan migrate
```

## Usage

Add the Umami script to your Blade layout (typically in the `<head>` section):

```blade
@include('umami::script')
```

### Configuring Settings

Settings are stored in the database and can be managed via code:

```php
use JeffersonGoncalves\Umami\Settings\UmamiSettings;

$settings = app(UmamiSettings::class);
$settings->website_id = 'your-website-id';
$settings->host_analytics = 'https://your-umami-instance.com';
$settings->save();
```

### Available Settings

| Property | Type | Default | Description |
|----------|------|---------|-------------|
| `website_id` | `?string` | `null` | Your Umami website ID (required for tracking) |
| `host_analytics` | `string` | `https://cloud.umami.is` | URL of your Umami instance |
| `host_url` | `?string` | `null` | Override data destination URL |
| `auto_track` | `bool` | `true` | Automatically track pageviews and events |
| `domains` | `?string` | `null` | Comma-delimited list of allowed domains |
| `tag` | `?string` | `null` | Tag to group events in the dashboard |
| `exclude_search` | `bool` | `false` | Exclude search parameters from URL |
| `exclude_hash` | `bool` | `false` | Exclude hash value from URL |

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Jefferson Goncalves](https://github.com/jeffersongoncalves)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
