<?php

namespace AppModule\Checkout\Repositories;

use AppModule\Core\Eloquent\Repository;

class CartAddressRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    function model(): string
    {
        return 'AppModule\Checkout\Contracts\CartAddress';
    }
}