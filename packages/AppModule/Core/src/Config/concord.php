<?php

return [

    'convention' => AppModule\Core\CoreConvention::class,

    'modules' => [

        /**
         * Example:
         * VendorA\ModuleX\Providers\ModuleServiceProvider::class,
         * VendorB\ModuleY\Providers\ModuleServiceProvider::class
         *
         */

        \AppModule\Admin\Providers\ModuleServiceProvider::class,
        \AppModule\Attribute\Providers\ModuleServiceProvider::class,
        \AppModule\BookingProduct\Providers\ModuleServiceProvider::class,
        \AppModule\CartRule\Providers\ModuleServiceProvider::class,
        \AppModule\CatalogRule\Providers\ModuleServiceProvider::class,
        \AppModule\Category\Providers\ModuleServiceProvider::class,
        \AppModule\Checkout\Providers\ModuleServiceProvider::class,
        \AppModule\Core\Providers\ModuleServiceProvider::class,
        \AppModule\CMS\Providers\ModuleServiceProvider::class,
        \AppModule\Customer\Providers\ModuleServiceProvider::class,
        \AppModule\Inventory\Providers\ModuleServiceProvider::class,
        \AppModule\Marketing\Providers\ModuleServiceProvider::class,
        \AppModule\Payment\Providers\ModuleServiceProvider::class,
        \AppModule\Paypal\Providers\ModuleServiceProvider::class,
        \AppModule\Product\Providers\ModuleServiceProvider::class,
        \AppModule\Rule\Providers\ModuleServiceProvider::class,
        \AppModule\Sales\Providers\ModuleServiceProvider::class,
        \AppModule\Shipping\Providers\ModuleServiceProvider::class,
        \AppModule\Shop\Providers\ModuleServiceProvider::class,
        \AppModule\SocialLogin\Providers\ModuleServiceProvider::class,
        \AppModule\Tax\Providers\ModuleServiceProvider::class,
        \AppModule\Theme\Providers\ModuleServiceProvider::class,
        \AppModule\Ui\Providers\ModuleServiceProvider::class,
        \AppModule\User\Providers\ModuleServiceProvider::class,
        \AppModule\Velocity\Providers\ModuleServiceProvider::class,
        \AppModule\Sitemap\Providers\ModuleServiceProvider::class,

    ],
];
