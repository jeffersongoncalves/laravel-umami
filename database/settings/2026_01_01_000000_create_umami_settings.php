<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('umami.website_id', null);
        $this->migrator->add('umami.host_analytics', 'https://cloud.umami.is');
        $this->migrator->add('umami.host_url', null);
        $this->migrator->add('umami.auto_track', true);
        $this->migrator->add('umami.domains', null);
        $this->migrator->add('umami.tag', null);
        $this->migrator->add('umami.exclude_search', false);
        $this->migrator->add('umami.exclude_hash', false);
    }
};
