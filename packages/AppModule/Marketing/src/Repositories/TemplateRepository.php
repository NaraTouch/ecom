<?php

namespace AppModule\Marketing\Repositories;

use AppModule\Core\Eloquent\Repository;

class TemplateRepository extends Repository
{
    /**
     * Specify model class name.
     *
     * @return string
     */
    public function model(): string
    {
        return 'AppModule\Marketing\Contracts\Template';
    }
}
