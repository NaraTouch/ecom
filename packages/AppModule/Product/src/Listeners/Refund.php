<?php

namespace AppModule\Product\Listeners;

use AppModule\Product\Helpers\Indexers\Inventory;

class Refund
{
    /**
     * Create a new listener instance.
     *
     * @param  \AppModule\Product\Helpers\Indexers\Inventory  $inventoryIndexer
     * @return void
     */
    public function __construct(protected Inventory $inventoryIndexer)
    {
    }

    /**
     * After refund is created
     *
     * @param  \AppModule\Sale\Contracts\Refund  $refund
     * @return void
     */
    public function afterCreate($refund)
    {
        $products = [];

        foreach ($refund->items as $item) {
            $products[] = $item->product;
        }

        $this->inventoryIndexer->reindexRows($products);
    }
}
