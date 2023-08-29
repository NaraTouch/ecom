<?php

namespace AppModule\Product\Repositories;

use AppModule\Core\Eloquent\Repository;

class ProductPriceIndexRepository extends Repository
{
    /**
     * Specify model class name.
     *
     * @return string
     */
    public function model(): string
    {
        return 'AppModule\Product\Contracts\ProductPriceIndex';
    }
}
