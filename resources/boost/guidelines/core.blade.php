## Laravel Umami

### Overview

Laravel Umami integrates [Umami Analytics](https://umami.is) into Laravel Blade views.
It uses `spatie/laravel-settings` to store configuration in the database, requiring no config files.
The package auto-registers its service provider and settings migration.

**Namespace:** `JeffersonGoncalves\Umami`
**Service Provider:** `UmamiServiceProvider` (extends `Spatie\LaravelPackageTools\PackageServiceProvider`)

### Key Concepts

- **No config file** -- all settings are stored in the database via `spatie/laravel-settings`.
- **Blade view** -- include `@include('umami::script')` in your layout.
- The tracking script only renders when `website_id` is not empty.
- Supports self-hosted Umami instances via the `host_analytics` setting.
- Supports advanced tracking options: auto-track, domains filtering, tagging, hash/search exclusion.

### Settings (spatie/laravel-settings)

Settings class: `JeffersonGoncalves\Umami\Settings\UmamiSettings`
Group: `umami`

| Property | Type | Default | Description |
|----------|------|---------|-------------|
| `website_id` | `?string` | `null` | Umami website ID |
| `host_analytics` | `string` | `https://cloud.umami.is` | Umami instance URL |
| `host_url` | `?string` | `null` | Custom host URL for data collection |
| `auto_track` | `bool` | `true` | Enable automatic page view tracking |
| `domains` | `?string` | `null` | Comma-separated list of allowed domains |
| `tag` | `?string` | `null` | Tag for filtering analytics data |
| `exclude_search` | `bool` | `false` | Exclude search params from tracked URLs |
| `exclude_hash` | `bool` | `false` | Exclude hash from tracked URLs |

@verbatim
<code-snippet name="read-settings" lang="php">
use JeffersonGoncalves\Umami\Settings\UmamiSettings;

$settings = app(UmamiSettings::class);
$settings->website_id;      // ?string
$settings->host_analytics;  // string
$settings->host_url;        // ?string
$settings->auto_track;      // bool
$settings->domains;         // ?string
$settings->tag;             // ?string
$settings->exclude_search;  // bool
$settings->exclude_hash;    // bool
</code-snippet>
@endverbatim

@verbatim
<code-snippet name="update-settings" lang="php">
use JeffersonGoncalves\Umami\Settings\UmamiSettings;

$settings = app(UmamiSettings::class);
$settings->website_id = 'your-website-id';
$settings->host_analytics = 'https://analytics.example.com';
$settings->auto_track = true;
$settings->save();
</code-snippet>
@endverbatim

### Configuration

No config file is published. All configuration is managed through the `UmamiSettings` class.

**Publish settings migration:**

@verbatim
<code-snippet name="publish-migration" lang="bash">
php artisan vendor:publish --tag="umami-settings-migrations"
php artisan migrate
</code-snippet>
@endverbatim

### Blade Integration

Include the tracking script in your layout's `<head>`:

@verbatim
<code-snippet name="blade-include" lang="blade">
{{-- In your layout file (e.g., layouts/app.blade.php) --}}
<head>
    @include('umami::script')
</head>
</code-snippet>
@endverbatim

The script renders with all configured data attributes:

@verbatim
<code-snippet name="rendered-output" lang="html">
<script async defer data-website-id="your-id"
        src="https://cloud.umami.is/script.js"
        data-host-url="https://custom-host.com"
        data-domains="example.com"
        data-tag="marketing"
        data-auto-track="true"
        data-exclude-search="false"
        data-exclude-hash="false">
</script>
</code-snippet>
@endverbatim

### Conventions

- Settings group name: `umami`
- View namespace: `umami`
- Package name: `laravel-umami`
- Migration publish tag: `umami-settings-migrations`
- No models or relationships -- this is a script-injection package.
- PHP 8.2+ required, Laravel 11+, spatie/laravel-settings ^3.3.
