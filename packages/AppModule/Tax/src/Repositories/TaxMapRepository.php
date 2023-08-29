<?php

namespace AppModule\Tax\Repositories;

use AppModule\Core\Eloquent\Repository;

class TaxMapRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    function model(): string
    {
        return 'AppModule\Tax\Contracts\TaxMap';
    }
}