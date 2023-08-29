<?php

if (! function_exists('cart')) {
    /**
     * Cart helper.
     *
     * @return \AppModule\Checkout\Cart
     */
    function cart()
    {
        return app()->make('cart');
    }
}
