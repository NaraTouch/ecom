<?php

namespace AppModule\Core\Repositories;

use Prettus\Repository\Traits\CacheableRepository;
use AppModule\Core\Eloquent\Repository;

class ExchangeRateRepository extends Repository
{
    use CacheableRepository;

    /**
     * Specify model class name.
     *
     * @return string
     */
    public function model(): string
    {
        return 'AppModule\Core\Contracts\CurrencyExchangeRate';
    }
}
