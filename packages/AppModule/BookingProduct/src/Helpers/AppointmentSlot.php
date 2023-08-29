<?php

namespace AppModule\BookingProduct\Helpers;

class AppointmentSlot extends Booking
{
    /**
     * @param  int  $qty
     * @param  \AppModule\BookingProduct\Contracts\BookingProduct  $bookingProduct
     * @return bool
     */
    public function haveSufficientQuantity(int $qty, $bookingProduct): bool
    {
        return true;
    }
}