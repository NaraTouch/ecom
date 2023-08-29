<?php

namespace AppModule\Velocity\Repositories;

use AppModule\Core\Eloquent\Repository;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * OrderBrands Repository
 *
 * @copyright 2019 AppModule Software Pvt Ltd (http://www.AppModule.com)
 */
class OrderBrandsRepository extends Repository
{
    use CacheableRepository;

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model(): string
    {
        return 'AppModule\Velocity\Contracts\OrderBrand';
    }

}