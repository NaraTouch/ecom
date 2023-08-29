<?php

namespace AppModule\Product\Providers;

use AppModule\Core\Providers\CoreModuleServiceProvider;

class ModuleServiceProvider extends CoreModuleServiceProvider
{
    protected $models = [
        \AppModule\Product\Models\Product::class,
        \AppModule\Product\Models\ProductAttributeValue::class,
        \AppModule\Product\Models\ProductBundleOption::class,
        \AppModule\Product\Models\ProductBundleOptionProduct::class,
        \AppModule\Product\Models\ProductBundleOptionTranslation::class,
        \AppModule\Product\Models\ProductCustomerGroupPrice::class,
        \AppModule\Product\Models\ProductDownloadableLink::class,
        \AppModule\Product\Models\ProductDownloadableSample::class,
        \AppModule\Product\Models\ProductFlat::class,
        \AppModule\Product\Models\ProductGroupedProduct::class,
        \AppModule\Product\Models\ProductImage::class,
        \AppModule\Product\Models\ProductInventory::class,
        \AppModule\Product\Models\ProductInventoryIndex::class,
        \AppModule\Product\Models\ProductOrderedInventory::class,
        \AppModule\Product\Models\ProductPriceIndex::class,
        \AppModule\Product\Models\ProductReview::class,
        \AppModule\Product\Models\ProductReviewImage::class,
        \AppModule\Product\Models\ProductSalableInventory::class,
        \AppModule\Product\Models\ProductVideo::class,
    ];
}