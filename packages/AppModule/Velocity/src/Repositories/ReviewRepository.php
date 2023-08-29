<?php

namespace AppModule\Velocity\Repositories;

use AppModule\Core\Eloquent\Repository;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Review Repository
 *
 * @copyright 2019 AppModule Software Pvt Ltd (http://www.AppModule.com)
 */
class ReviewRepository extends Repository
{
    use CacheableRepository;

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model(): string
    {
        return 'AppModule\Product\Contracts\ProductReview';
    }
}