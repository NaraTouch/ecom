<?php

namespace AppModule\Customer\Providers;

use AppModule\Core\Providers\CoreModuleServiceProvider;

class ModuleServiceProvider extends CoreModuleServiceProvider
{
    protected $models = [
        \AppModule\Customer\Models\Customer::class,
        \AppModule\Customer\Models\CustomerAddress::class,
        \AppModule\Customer\Models\CustomerGroup::class,
        \AppModule\Customer\Models\Wishlist::class,
    ];
}