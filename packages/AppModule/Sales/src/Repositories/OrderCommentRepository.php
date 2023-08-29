<?php

namespace AppModule\Sales\Repositories;

use AppModule\Core\Eloquent\Repository;
use AppModule\Sales\Contracts\OrderComment;

class OrderCommentRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return 'AppModule\Sales\Contracts\OrderComment';
    }
}
