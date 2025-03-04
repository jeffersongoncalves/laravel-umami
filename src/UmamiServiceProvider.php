<?php

namespace JeffersonGoncalves\Umami;

use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\LaravelPackageTools\Package;

class UmamiServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('laravel-umami')
            ->hasConfigFile('umami')
            ->hasViews();
    }
}
