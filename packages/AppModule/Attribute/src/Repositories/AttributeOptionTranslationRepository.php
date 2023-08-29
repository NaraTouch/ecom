<?php

namespace AppModule\Attribute\Repositories;

use AppModule\Core\Eloquent\Repository;

class AttributeOptionTranslationRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    function model(): string
    {
        return 'AppModule\Attribute\Contracts\AttributeOptionTranslation';
    }
}