<?php

namespace AppModule\Notification\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen('checkout.order.save.after', 'AppModule\Notification\Listeners\Order@createOrder');

        Event::listen('sales.order.update-status.after', 'AppModule\Notification\Listeners\Order@updateOrder');
    }
}
