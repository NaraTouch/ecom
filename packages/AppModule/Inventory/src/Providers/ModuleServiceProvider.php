<?php

namespace AppModule\Inventory\Providers;

use AppModule\Core\Providers\CoreModuleServiceProvider;

class ModuleServiceProvider extends CoreModuleServiceProvider
{
    protected $models = [
        \AppModule\Inventory\Models\InventorySource::class,
    ];
}