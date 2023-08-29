<?php

namespace AppModule\Checkout\Providers;

use AppModule\Core\Providers\CoreModuleServiceProvider;

class ModuleServiceProvider extends CoreModuleServiceProvider
{
    protected $models = [
        \AppModule\Checkout\Models\Cart::class,
        \AppModule\Checkout\Models\CartAddress::class,
        \AppModule\Checkout\Models\CartItem::class,
        \AppModule\Checkout\Models\CartPayment::class,
        \AppModule\Checkout\Models\CartShippingRate::class,
    ];
}