<?php

namespace AppModule\Product\CacheFilters;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class Medium implements FilterInterface
{
    /**
     * Apply filter.
     *
     * @param  \Intervention\Image\Image  $image
     * @return \Intervention\Image\Image
     */
    public function applyFilter(Image $image)
    {
        $width = core()->getConfigData('catalog.products.cache-medium-image.width') != ''
            ? core()->getConfigData('catalog.products.cache-medium-image.width')
            : 225;

        $height = core()->getConfigData('catalog.products.cache-medium-image.height') != ''
            ? core()->getConfigData('catalog.products.cache-medium-image.height')
            : null;

        $image->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });

        return $image->resizeCanvas($width, $height, 'center', false, '#fff');
    }
}
