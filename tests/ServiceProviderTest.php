<?php

it('prepends the vendor settings migrations path so the app path wins on basename collision', function (): void {
    $paths = config('settings.migrations_paths');

    expect($paths)->toHaveCount(2)
        ->and(realpath($paths[0]))->toBe(realpath(__DIR__.'/../database/settings'))
        ->and($paths[1])->toBe(database_path('settings'));
});
