<?php

namespace AppModule\Velocity\Repositories;

use AppModule\Core\Eloquent\Repository;

class VelocityMetadataRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    function model(): string
    {
        return 'AppModule\Velocity\Contracts\VelocityMetadata';
    }
}