<?php

namespace AppModule\BookingProduct\Listeners;

use AppModule\BookingProduct\Repositories\BookingRepository;

class Order
{
    /**
     * Create a new listener instance.
     *
     * @param  \AppModule\Booking\Repositories\BookingRepository  $bookingRepository
     * @return void
     */
    public function __construct(protected BookingRepository $bookingRepository)
    {
    }

    /**
     * After sales order creation, add entry to bookings table
     *
     * @param  \AppModule\Sales\Contracts\Order  $order
     * @return void
     */
    public function afterPlaceOrder($order)
    {
        $this->bookingRepository->create(['order' => $order]);
    }
}