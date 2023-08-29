<?php

namespace AppModule\Inventory\Repositories;

use AppModule\Core\Eloquent\Repository;

class InventorySourceRepository extends Repository
{
    /**
     * Specify model class name.
     *
     * @return string
     */
    public function model(): string
    {
        return 'AppModule\Inventory\Contracts\InventorySource';
    }
}
