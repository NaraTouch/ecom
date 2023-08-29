<?php

namespace AppModule\Sitemap\Models;

use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;
use AppModule\Product\Models\Product as BaseProduct;

class Product extends BaseProduct implements Sitemapable
{
    /**
     * @return mixed
     */
    public function toSitemapTag(): Url | string | array
    {
        if (
            ! $this->url_key
            || ! $this->status
            || ! $this->visible_individually
        ) {
            return [];
        }

        return route('shop.productOrCategory.index', $this->url_key);
    }
}