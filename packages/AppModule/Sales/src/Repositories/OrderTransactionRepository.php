<?php

namespace AppModule\Sales\Repositories;

use AppModule\Core\Eloquent\Repository;

/**
 * Order Transaction Repository
 *
 * @author    Jitendra Singh <jitendra@AppModule.com>
 * @copyright 2018 AppModule Software Pvt Ltd (http://www.AppModule.com)
 */
class OrderTransactionRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    function model(): string
    {
        return 'AppModule\Sales\Contracts\OrderTransaction';
    }
}