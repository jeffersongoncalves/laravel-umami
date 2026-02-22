<?php

namespace JeffersonGoncalves\Umami\Settings;

use Spatie\LaravelSettings\Settings;

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

    public static function group(): string
    {
        return 'umami';
    }
}
