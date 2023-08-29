<?php

namespace AppModule\Tax\Repositories;

use AppModule\Core\Eloquent\Repository;

class TaxCategoryRepository extends Repository
{
    /**
     * Specify model class name.
     *
     * @return string
     */
    public function model(): string
    {
        return 'AppModule\Tax\Contracts\TaxCategory';
    }
}
