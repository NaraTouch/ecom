<?php

namespace AppModule\Tax\Repositories;

use AppModule\Core\Eloquent\Repository;

class TaxRateRepository extends Repository
{
    /**
     * Specify model class name.
     *
     * @return string
     */
    public function model(): string
    {
        return 'AppModule\Tax\Contracts\TaxRate';
    }
}
