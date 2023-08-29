<?php

namespace AppModule\BookingProduct\Providers;

use AppModule\Core\Providers\CoreModuleServiceProvider;

class ModuleServiceProvider extends CoreModuleServiceProvider
{
    protected $models = [
        \AppModule\BookingProduct\Models\BookingProduct::class,
        \AppModule\BookingProduct\Models\BookingProductDefaultSlot::class,
        \AppModule\BookingProduct\Models\BookingProductAppointmentSlot::class,
        \AppModule\BookingProduct\Models\BookingProductEventTicket::class,
        \AppModule\BookingProduct\Models\BookingProductEventTicketTranslation::class,
        \AppModule\BookingProduct\Models\BookingProductRentalSlot::class,
        \AppModule\BookingProduct\Models\BookingProductTableSlot::class,
        \AppModule\BookingProduct\Models\Booking::class,
    ];
}