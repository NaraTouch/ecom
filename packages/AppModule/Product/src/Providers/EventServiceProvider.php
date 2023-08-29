<?php

namespace AppModule\Product\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'catalog.product.create.after'  => [
            'AppModule\Product\Listeners\Product@afterCreate',
        ],
        'catalog.product.update.after'  => [
            'AppModule\Product\Listeners\Product@afterUpdate',
        ],
        'catalog.product.delete.before' => [
            'AppModule\Product\Listeners\Product@beforeDelete',
        ],
        'checkout.order.save.after'     => [
            'AppModule\Product\Listeners\Order@afterCancelOrCreate',
        ],
        'sales.order.cancel.after'      => [
            'AppModule\Product\Listeners\Order@afterCancelOrCreate',
        ],
        'sales.refund.save.after'       => [
            'AppModule\Product\Listeners\Refund@afterCreate',
        ],
    ];
}