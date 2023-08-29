<?php

namespace AppModule\CMS\Providers;

use Illuminate\Support\ServiceProvider;
use AppModule\CMS\Providers\ModuleServiceProvider;

class CMSServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}