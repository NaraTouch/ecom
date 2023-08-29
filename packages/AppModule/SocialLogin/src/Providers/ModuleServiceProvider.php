<?php

namespace AppModule\SocialLogin\Providers;

use AppModule\Core\Providers\CoreModuleServiceProvider;

class ModuleServiceProvider extends CoreModuleServiceProvider
{
    protected $models = [
        \AppModule\SocialLogin\Models\CustomerSocialAccount::class,
    ];
}