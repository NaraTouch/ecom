<?php

namespace AppModule\CatalogRule\Listeners;

use AppModule\CatalogRule\Helpers\CatalogRuleIndex;

class Product
{
    /**
     * Create a new listener instance.
     * 
     * @param  \AppModule\CatalogRule\Helpers\CatalogRuleIndex  $catalogRuleIndexHelper
     * @return void
     */
    public function __construct(protected CatalogRuleIndex $catalogRuleIndexHelper)
    {
    }

    /**
     * @param  \AppModule\Product\Contracts\Product  $product
     * @return void
     */
    public function createProductRuleIndex($product)
    {
        $this->catalogRuleIndexHelper->reIndexProduct($product);
    }
}