<?php

namespace AppModule\User\Repositories;

use AppModule\Core\Eloquent\Repository;

class RoleRepository extends Repository
{
    /**
     * Specify model class name.
     *
     * @return string
     */
    public function model(): string
    {
        return 'AppModule\User\Contracts\Role';
    }
}
