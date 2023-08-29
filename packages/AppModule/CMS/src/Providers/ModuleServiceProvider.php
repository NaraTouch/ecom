<?php

namespace AppModule\CMS\Providers;

use AppModule\Core\Providers\CoreModuleServiceProvider;

class ModuleServiceProvider extends CoreModuleServiceProvider
{
    protected $models = [
        \AppModule\CMS\Models\CmsPage::class,
        \AppModule\CMS\Models\CmsPageTranslation::class
    ];
}