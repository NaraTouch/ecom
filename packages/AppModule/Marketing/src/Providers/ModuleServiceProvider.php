<?php

namespace AppModule\Marketing\Providers;

use AppModule\Core\Providers\CoreModuleServiceProvider;

class ModuleServiceProvider extends CoreModuleServiceProvider
{
    protected $models = [
        \AppModule\Marketing\Models\Campaign::class,
        \AppModule\Marketing\Models\Template::class,
        \AppModule\Marketing\Models\Event::class,
    ];
}