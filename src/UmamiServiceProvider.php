<?php

namespace JeffersonGoncalves\Umami;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class UmamiServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('laravel-umami')
            ->hasConfigFile('umami')
            ->hasViews();
    }
}
