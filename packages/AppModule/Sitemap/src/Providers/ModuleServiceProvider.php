<?php

namespace AppModule\Sitemap\Providers;

use AppModule\Core\Providers\CoreModuleServiceProvider;

class ModuleServiceProvider extends CoreModuleServiceProvider
{
    protected $models = [
        \AppModule\Sitemap\Models\Sitemap::class,
    ];
}