<?php

namespace AppModule\Category\Providers;

use AppModule\Core\Providers\CoreModuleServiceProvider;

class ModuleServiceProvider extends CoreModuleServiceProvider
{
    protected $models = [
        \AppModule\Category\Models\Category::class,
        \AppModule\Category\Models\CategoryTranslation::class,
    ];
}