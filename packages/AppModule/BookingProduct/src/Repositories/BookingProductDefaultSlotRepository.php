<?php

namespace AppModule\BookingProduct\Repositories;

use AppModule\Core\Eloquent\Repository;

class BookingProductDefaultSlotRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    function model(): string
    {
        return 'AppModule\BookingProduct\Contracts\BookingProductDefaultSlot';
    }
}