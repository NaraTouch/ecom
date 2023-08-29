<?php

namespace AppModule\Attribute\Providers;

use AppModule\Core\Providers\CoreModuleServiceProvider;

class ModuleServiceProvider extends CoreModuleServiceProvider
{
    protected $models = [
        \AppModule\Attribute\Models\Attribute::class,
        \AppModule\Attribute\Models\AttributeFamily::class,
        \AppModule\Attribute\Models\AttributeGroup::class,
        \AppModule\Attribute\Models\AttributeOption::class,
        \AppModule\Attribute\Models\AttributeOptionTranslation::class,
        \AppModule\Attribute\Models\AttributeTranslation::class,
    ];
}