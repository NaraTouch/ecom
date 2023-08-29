<?php

namespace AppModule\CartRule\Providers;

use AppModule\Core\Providers\CoreModuleServiceProvider;

class ModuleServiceProvider extends CoreModuleServiceProvider
{
    protected $models = [
        \AppModule\CartRule\Models\CartRule::class,
        \AppModule\CartRule\Models\CartRuleTranslation::class,
        \AppModule\CartRule\Models\CartRuleCustomer::class,
        \AppModule\CartRule\Models\CartRuleCoupon::class,
        \AppModule\CartRule\Models\CartRuleCouponUsage::class,
    ];
}