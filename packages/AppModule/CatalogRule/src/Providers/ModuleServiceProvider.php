<?php

namespace AppModule\CatalogRule\Providers;

use AppModule\Core\Providers\CoreModuleServiceProvider;

class ModuleServiceProvider extends CoreModuleServiceProvider
{
    protected $models = [
        \AppModule\CatalogRule\Models\CatalogRule::class,
        \AppModule\CatalogRule\Models\CatalogRuleProduct::class,
        \AppModule\CatalogRule\Models\CatalogRuleProductPrice::class,
    ];
}