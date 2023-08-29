<?php

namespace AppModule\CatalogRule\Repositories;

use AppModule\Core\Eloquent\Repository;

class CatalogRuleProductRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    function model(): string
    {
        return 'AppModule\CatalogRule\Contracts\CatalogRuleProduct';
    }
}