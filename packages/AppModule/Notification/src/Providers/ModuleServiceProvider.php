<?php

namespace AppModule\Notification\Providers;

use Konekt\Concord\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \AppModule\Notification\Models\Notification::class
    ];
}