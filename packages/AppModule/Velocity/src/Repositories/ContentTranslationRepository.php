<?php

namespace AppModule\Velocity\Repositories;

use AppModule\Core\Eloquent\Repository;
use Prettus\Repository\Traits\CacheableRepository;

class ContentTranslationRepository extends Repository
{
    use CacheableRepository;

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model(): string
    {
        return 'AppModule\Velocity\Contracts\ContentTranslation';
    }
}