<?php

namespace AppModule\Customer\Helpers;

class Wishlist
{
    /**
     * Returns wishlist products for current customer.
     *
     * @param  \AppModule\Product\Contracts\Product  $product
     * @return AppModule\Customer\Contracts\Wishlist|null
     */
    public function getWishlistProduct($product)
    {
        $wishlist = false;

        if ($customer = auth()->guard()->user()) {
            $wishlist = $customer->wishlist_items->filter(function ($item) use ($product) {
                return $item->channel_id == core()->getCurrentChannel()->id && $item->product_id == $product->id;
            })->first();
        }

        if ($wishlist) {
            return $wishlist;
        }

        return null;
    }
}