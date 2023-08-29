<?php

namespace AppModule\Product\Repositories;

use AppModule\Core\Eloquent\Repository;

class ProductInventoryIndexRepository extends Repository
{
    /**
     * Specify model class name.
     *
     * @return string
     */
    public function model(): string
    {
        return 'AppModule\Product\Contracts\ProductInventoryIndex';
    }
}
