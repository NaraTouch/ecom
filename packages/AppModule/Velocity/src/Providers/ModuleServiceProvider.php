<?php

namespace AppModule\Velocity\Providers;

use AppModule\Core\Providers\CoreModuleServiceProvider;

class ModuleServiceProvider extends CoreModuleServiceProvider
{
    protected $models = [
        \AppModule\Velocity\Models\Category::class,
        \AppModule\Velocity\Models\Content::class,
        \AppModule\Velocity\Models\ContentTranslation::class,
        \AppModule\Velocity\Models\OrderBrand::class,
        \AppModule\Velocity\Models\VelocityCustomerCompareProduct::class,
        \AppModule\Velocity\Models\VelocityMetadata::class,
    ];
}