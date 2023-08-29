<?php

namespace AppModule\User\Providers;

use AppModule\Core\Providers\CoreModuleServiceProvider;

class ModuleServiceProvider extends CoreModuleServiceProvider
{
    protected $models = [
        \AppModule\User\Models\Admin::class,
        \AppModule\User\Models\Role::class,
    ];
}