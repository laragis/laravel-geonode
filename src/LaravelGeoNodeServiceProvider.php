<?php

namespace TungTT\LaravelGeoNode;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use TungTT\LaravelGeoNode\Commands\LaravelGeonodeCommand;

class LaravelGeoNodeServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-geonode')
            ->hasRoute('web')
            ->hasConfigFile();
    }
}
