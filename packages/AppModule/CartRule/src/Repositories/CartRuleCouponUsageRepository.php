<?php

namespace AppModule\CartRule\Repositories;

use AppModule\Core\Eloquent\Repository;

class CartRuleCouponUsageRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    function model(): string
    {
        return 'AppModule\CartRule\Contracts\CartRuleCouponUsage';
    }
}