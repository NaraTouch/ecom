<?php

namespace AppModule\BookingProduct\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use AppModule\Theme\ViewRenderEventManager;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'checkout.order.save.after' => [
            'AppModule\BookingProduct\Listeners\Order@afterPlaceOrder'
        ],
    ];

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Event::listen('module.shop.products.view.short_description.after', static function(ViewRenderEventManager $viewRenderEventManager) {
            if (View::exists('bookingproduct::shop.' . core()->getCurrentChannel()->theme . '.products.view.booking')) {
                $viewRenderEventManager->addTemplate('bookingproduct::shop.' . core()->getCurrentChannel()->theme . '.products.view.booking');
            }
        });
    }
}
