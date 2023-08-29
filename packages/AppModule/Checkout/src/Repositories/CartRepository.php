<?php

namespace AppModule\Checkout\Repositories;

use AppModule\Core\Eloquent\Repository;

class CartRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    function model(): string
    {
        return 'AppModule\Checkout\Contracts\Cart';
    }

    /**
     * Method to detach associations. Use this only with guest cart only.
     * 
     * @param  int  $cartId
     * @return bool
     */
    public function deleteParent($cartId)
    {
        return $this->model->destroy($cartId);
    }
}