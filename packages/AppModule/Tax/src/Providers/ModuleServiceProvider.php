<?php

namespace AppModule\Tax\Providers;

use AppModule\Core\Providers\CoreModuleServiceProvider;

class ModuleServiceProvider extends CoreModuleServiceProvider
{
    protected $models = [
        \AppModule\Tax\Models\TaxCategory::class,
        \AppModule\Tax\Models\TaxMap::class,
        \AppModule\Tax\Models\TaxRate::class,
    ];
}